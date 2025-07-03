import json
import numpy as np
from typing import List, Dict, Any, Optional, Tuple
from pathlib import Path
from sentence_transformers import SentenceTransformer
from qdrant_client import QdrantClient
from qdrant_client.models import Distance, VectorParams, PointStruct
import chromadb
import lancedb
import uuid
from datetime import datetime

from config import Config

class LocalVectorStore:
    def __init__(self, collection_name: str = "repo_knowledge"):
        self.config = Config()
        self.collection_name = collection_name
        self.embedding_model = SentenceTransformer(self.config.EMBEDDING_MODEL)
        self.client = None
        self.collection = None
        
        self._initialize_vector_store()
    
    def _initialize_vector_store(self):
        """Initialize the selected vector store"""
        if self.config.VECTOR_DB_TYPE == "qdrant":
            self._init_qdrant()
        elif self.config.VECTOR_DB_TYPE == "chroma":
            self._init_chroma()
        elif self.config.VECTOR_DB_TYPE == "lancedb":
            self._init_lancedb()
        else:
            raise ValueError(f"Unsupported vector store: {self.config.VECTOR_DB_TYPE}")
    
    def _init_qdrant(self):
        """Initialize Qdrant vector store"""
        try:
            self.client = QdrantClient(
                host=self.config.QDRANT_HOST,
                port=self.config.QDRANT_PORT
            )
        except:
            # Fallback to in-memory if server not available
            self.client = QdrantClient(":memory:")
        
        # Create collection if it doesn't exist
        collections = self.client.get_collections().collections
        if not any(c.name == self.collection_name for c in collections):
            self.client.create_collection(
                collection_name=self.collection_name,
                vectors_config=VectorParams(
                    size=self.embedding_model.get_sentence_embedding_dimension(),
                    distance=Distance.COSINE
                )
            )
    
    def _init_chroma(self):
        """Initialize ChromaDB vector store"""
        self.client = chromadb.PersistentClient(path=str(self.config.VECTOR_DB_DIR))
        self.collection = self.client.get_or_create_collection(
            name=self.collection_name,
            metadata={"hnsw:space": "cosine"}
        )
    
    def _init_lancedb(self):
        """Initialize LanceDB vector store"""
        self.client = lancedb.connect(str(self.config.VECTOR_DB_DIR))
        
        # Create table if it doesn't exist
        try:
            self.collection = self.client.open_table(self.collection_name)
        except:
            # Create new table
            data = []  # Empty data for schema
            self.collection = self.client.create_table(
                self.collection_name,
                data,
                mode="overwrite"
            )
    
    def embed_text(self, text: str) -> List[float]:
        """Generate embeddings for text"""
        return self.embedding_model.encode(text).tolist()
    
    def embed_batch(self, texts: List[str]) -> List[List[float]]:
        """Generate embeddings for multiple texts"""
        return self.embedding_model.encode(texts).tolist()
    
    def add_documents(self, documents: List[Dict[str, Any]]) -> int:
        """Add documents to vector store"""
        if not documents:
            return 0
        
        # Prepare texts for embedding
        texts = []
        for doc in documents:
            # Combine path and content for better context
            text = f"File: {doc['path']}\n\nContent:\n{doc['content']}"
            texts.append(text)
        
        # Generate embeddings
        embeddings = self.embed_batch(texts)
        
        # Add to vector store based on type
        if self.config.VECTOR_DB_TYPE == "qdrant":
            return self._add_to_qdrant(documents, embeddings)
        elif self.config.VECTOR_DB_TYPE == "chroma":
            return self._add_to_chroma(documents, embeddings)
        elif self.config.VECTOR_DB_TYPE == "lancedb":
            return self._add_to_lancedb(documents, embeddings)
    
    def _add_to_qdrant(self, documents: List[Dict], embeddings: List[List[float]]) -> int:
        """Add documents to Qdrant"""
        points = []
        for i, (doc, embedding) in enumerate(zip(documents, embeddings)):
            points.append(PointStruct(
                id=str(uuid.uuid4()),
                vector=embedding,
                payload={
                    "repo_name": doc.get("repo_name", "unknown"),
                    "path": doc["path"],
                    "content": doc["content"],
                    "extension": doc.get("extension", ""),
                    "size": doc.get("size", 0),
                    "modified": doc.get("modified", ""),
                    "hash": doc.get("hash", ""),
                    "added_at": datetime.now().isoformat()
                }
            ))
        
        self.client.upsert(
            collection_name=self.collection_name,
            points=points
        )
        return len(points)
    
    def _add_to_chroma(self, documents: List[Dict], embeddings: List[List[float]]) -> int:
        """Add documents to ChromaDB"""
        ids = [str(uuid.uuid4()) for _ in documents]
        metadatas = []
        documents_text = []
        
        for doc in documents:
            metadatas.append({
                "repo_name": doc.get("repo_name", "unknown"),
                "path": doc["path"],
                "extension": doc.get("extension", ""),
                "size": doc.get("size", 0),
                "modified": doc.get("modified", ""),
                "hash": doc.get("hash", ""),
                "added_at": datetime.now().isoformat()
            })
            documents_text.append(doc["content"])
        
        self.collection.add(
            ids=ids,
            embeddings=embeddings,
            metadatas=metadatas,
            documents=documents_text
        )
        return len(ids)
    
    def _add_to_lancedb(self, documents: List[Dict], embeddings: List[List[float]]) -> int:
        """Add documents to LanceDB"""
        data = []
        for doc, embedding in zip(documents, embeddings):
            data.append({
                "id": str(uuid.uuid4()),
                "vector": embedding,
                "repo_name": doc.get("repo_name", "unknown"),
                "path": doc["path"],
                "content": doc["content"],
                "extension": doc.get("extension", ""),
                "size": doc.get("size", 0),
                "modified": doc.get("modified", ""),
                "hash": doc.get("hash", ""),
                "added_at": datetime.now().isoformat()
            })
        
        self.collection.add(data)
        return len(data)
    
    def search(self, query: str, limit: int = 10, filter_repo: Optional[str] = None) -> List[Dict]:
        """Search for similar documents"""
        query_embedding = self.embed_text(query)
        
        if self.config.VECTOR_DB_TYPE == "qdrant":
            return self._search_qdrant(query_embedding, limit, filter_repo)
        elif self.config.VECTOR_DB_TYPE == "chroma":
            return self._search_chroma(query_embedding, limit, filter_repo)
        elif self.config.VECTOR_DB_TYPE == "lancedb":
            return self._search_lancedb(query_embedding, limit, filter_repo)
    
    def _search_qdrant(self, query_embedding: List[float], limit: int, filter_repo: Optional[str]) -> List[Dict]:
        """Search in Qdrant"""
        search_filter = None
        if filter_repo:
            search_filter = {"must": [{"key": "repo_name", "match": {"value": filter_repo}}]}
        
        results = self.client.search(
            collection_name=self.collection_name,
            query_vector=query_embedding,
            limit=limit,
            query_filter=search_filter
        )
        
        return [
            {
                "score": result.score,
                "path": result.payload["path"],
                "content": result.payload["content"],
                "repo_name": result.payload["repo_name"],
                "extension": result.payload.get("extension", ""),
                "size": result.payload.get("size", 0)
            }
            for result in results
        ]
    
    def _search_chroma(self, query_embedding: List[float], limit: int, filter_repo: Optional[str]) -> List[Dict]:
        """Search in ChromaDB"""
        where_filter = None
        if filter_repo:
            where_filter = {"repo_name": filter_repo}
        
        results = self.collection.query(
            query_embeddings=[query_embedding],
            n_results=limit,
            where=where_filter
        )
        
        documents = []
        for i in range(len(results['ids'][0])):
            documents.append({
                "score": 1 - results['distances'][0][i],  # Convert distance to similarity
                "path": results['metadatas'][0][i]["path"],
                "content": results['documents'][0][i],
                "repo_name": results['metadatas'][0][i]["repo_name"],
                "extension": results['metadatas'][0][i].get("extension", ""),
                "size": results['metadatas'][0][i].get("size", 0)
            })
        
        return documents
    
    def _search_lancedb(self, query_embedding: List[float], limit: int, filter_repo: Optional[str]) -> List[Dict]:
        """Search in LanceDB"""
        query_builder = self.collection.search(query_embedding).limit(limit)
        
        if filter_repo:
            query_builder = query_builder.where(f"repo_name = '{filter_repo}'")
        
        results = query_builder.to_pandas()
        
        documents = []
        for _, row in results.iterrows():
            documents.append({
                "score": 1 / (1 + row['_distance']),  # Convert distance to similarity
                "path": row["path"],
                "content": row["content"],
                "repo_name": row["repo_name"],
                "extension": row.get("extension", ""),
                "size": row.get("size", 0)
            })
        
        return documents
    
    def get_stats(self) -> Dict[str, Any]:
        """Get statistics about the vector store"""
        if self.config.VECTOR_DB_TYPE == "qdrant":
            info = self.client.get_collection(self.collection_name)
            return {
                "total_documents": info.points_count,
                "vector_size": info.config.params.vectors.size,
                "distance_metric": info.config.params.vectors.distance.value
            }
        elif self.config.VECTOR_DB_TYPE == "chroma":
            return {
                "total_documents": self.collection.count(),
                "vector_size": self.embedding_model.get_sentence_embedding_dimension(),
                "distance_metric": "cosine"
            }
        elif self.config.VECTOR_DB_TYPE == "lancedb":
            return {
                "total_documents": len(self.collection),
                "vector_size": self.embedding_model.get_sentence_embedding_dimension(),
                "distance_metric": "cosine"
            }
    
    def delete_repo(self, repo_name: str) -> int:
        """Delete all documents from a specific repository"""
        if self.config.VECTOR_DB_TYPE == "qdrant":
            result = self.client.delete(
                collection_name=self.collection_name,
                points_selector={"filter": {"must": [{"key": "repo_name", "match": {"value": repo_name}}]}}
            )
            return result.operation_id
        elif self.config.VECTOR_DB_TYPE == "chroma":
            self.collection.delete(where={"repo_name": repo_name})
            return 1
        elif self.config.VECTOR_DB_TYPE == "lancedb":
            self.collection.delete(f"repo_name = '{repo_name}'")
            return 1 
