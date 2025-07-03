import json
from typing import List, Dict, Any, Optional
from pathlib import Path
from datetime import datetime

from repo_processor import LocalRepoProcessor
from vector_store import LocalVectorStore
from config import Config

class LocalKnowledgeGraph:
    def __init__(self, collection_name: str = "repo_knowledge"):
        self.config = Config()
        self.repo_processor = LocalRepoProcessor()
        self.vector_store = LocalVectorStore(collection_name)
        self.processed_repos = self._load_processed_repos()
    
    def _load_processed_repos(self) -> Dict[str, Dict]:
        """Load information about previously processed repositories"""
        repos_file = self.config.DATA_DIR / "processed_repos.json"
        if repos_file.exists():
            with open(repos_file, 'r') as f:
                return json.load(f)
        return {}
    
    def _save_processed_repos(self):
        """Save information about processed repositories"""
        repos_file = self.config.DATA_DIR / "processed_repos.json"
        with open(repos_file, 'w') as f:
            json.dump(self.processed_repos, f, indent=2)
    
    def add_repository(self, repo_source: str, repo_name: Optional[str] = None, is_url: bool = True) -> Dict[str, Any]:
        """Add a repository to the knowledge graph"""
        print(f"🔄 Adding repository to knowledge graph: {repo_source}")
        
        # Process repository
        result = self.repo_processor.process_repository(repo_source, is_url)
        
        # Extract repository name
        if not repo_name:
            repo_name = result['metadata'].name
        
        # Prepare documents for vector store
        with open(result['data_file'], 'r') as f:
            repo_data = json.load(f)
        
        documents = []
        for file_data in repo_data['files']:
            file_data['repo_name'] = repo_name
            documents.append(file_data)
        
        # Add to vector store
        print("📊 Adding documents to vector store...")
        docs_added = self.vector_store.add_documents(documents)
        
        # Update processed repos tracking
        self.processed_repos[repo_name] = {
            'source': repo_source,
            'is_url': is_url,
            'processed_at': datetime.now().isoformat(),
            'files_processed': len(documents),
            'data_file': result['data_file'],
            'repo_path': result['repo_path']
        }
        self._save_processed_repos()
        
        summary = {
            'repo_name': repo_name,
            'files_processed': len(documents),
            'documents_added': docs_added,
            'metadata': result['metadata'].__dict__,
            'processing_time': datetime.now().isoformat()
        }
        
        print(f"✅ Repository '{repo_name}' added successfully!")
        print(f"   📁 Files processed: {len(documents)}")
        print(f"   🔍 Documents added to vector store: {docs_added}")
        
        return summary
    
    def search(self, query: str, limit: int = 10, repo_filter: Optional[str] = None) -> List[Dict]:
        """Search across all repositories in the knowledge graph"""
        print(f"🔍 Searching: '{query}'")
        if repo_filter:
            print(f"   📁 Filtering by repository: {repo_filter}")
        
        results = self.vector_store.search(query, limit, repo_filter)
        
        print(f"   📊 Found {len(results)} results")
        return results
    
    def get_repository_info(self, repo_name: str) -> Optional[Dict]:
        """Get information about a specific repository"""
        return self.processed_repos.get(repo_name)
    
    def list_repositories(self) -> List[Dict]:
        """List all processed repositories"""
        repos = []
        for name, info in self.processed_repos.items():
            repos.append({
                'name': name,
                'source': info['source'],
                'processed_at': info['processed_at'],
                'files_processed': info['files_processed']
            })
        return repos
    
    def update_repository(self, repo_name: str) -> Dict[str, Any]:
        """Update an existing repository in the knowledge graph"""
        if repo_name not in self.processed_repos:
            raise ValueError(f"Repository '{repo_name}' not found in knowledge graph")
        
        repo_info = self.processed_repos[repo_name]
        
        print(f"🔄 Updating repository: {repo_name}")
        
        # Remove old documents
        self.vector_store.delete_repo(repo_name)
        
        # Re-add repository
        return self.add_repository(
            repo_info['source'],
            repo_name,
            repo_info['is_url']
        )
    
    def remove_repository(self, repo_name: str) -> bool:
        """Remove a repository from the knowledge graph"""
        if repo_name not in self.processed_repos:
            return False
        
        print(f"🗑️ Removing repository: {repo_name}")
        
        # Remove from vector store
        self.vector_store.delete_repo(repo_name)
        
        # Remove from processed repos
        del self.processed_repos[repo_name]
        self._save_processed_repos()
        
        print(f"✅ Repository '{repo_name}' removed successfully!")
        return True
    
    def get_stats(self) -> Dict[str, Any]:
        """Get statistics about the knowledge graph"""
        vector_stats = self.vector_store.get_stats()
        
        # Calculate additional stats
        total_repos = len(self.processed_repos)
        total_files = sum(repo['files_processed'] for repo in self.processed_repos.values())
        
        # Language statistics
        languages = {}
        for repo_name, repo_info in self.processed_repos.items():
            try:
                with open(repo_info['data_file'], 'r') as f:
                    repo_data = json.load(f)
                    for lang, count in repo_data['metadata']['languages'].items():
                        languages[lang] = languages.get(lang, 0) + count
            except:
                continue
        
        return {
            'total_repositories': total_repos,
            'total_files': total_files,
            'total_documents': vector_stats.get('total_documents', 0),
            'vector_size': vector_stats.get('vector_size', 0),
            'distance_metric': vector_stats.get('distance_metric', 'unknown'),
            'languages': languages,
            'repositories': self.list_repositories()
        }
    
    def export_knowledge_graph(self, output_file: str) -> str:
        """Export the entire knowledge graph to a file"""
        export_data = {
            'exported_at': datetime.now().isoformat(),
            'stats': self.get_stats(),
            'repositories': self.processed_repos
        }
        
        output_path = Path(output_file)
        with open(output_path, 'w') as f:
            json.dump(export_data, f, indent=2)
        
        print(f"📤 Knowledge graph exported to: {output_path}")
        return str(output_path)
    
    def semantic_search_with_context(self, query: str, limit: int = 5) -> Dict[str, Any]:
        """Perform semantic search and return results with enhanced context"""
        results = self.search(query, limit)
        
        # Group results by repository
        repo_results = {}
        for result in results:
            repo_name = result['repo_name']
            if repo_name not in repo_results:
                repo_results[repo_name] = []
            repo_results[repo_name].append(result)
        
        # Add repository context
        enhanced_results = {}
        for repo_name, repo_files in repo_results.items():
            repo_info = self.get_repository_info(repo_name)
            enhanced_results[repo_name] = {
                'repository_info': repo_info,
                'matching_files': repo_files,
                'relevance_score': sum(f['score'] for f in repo_files) / len(repo_files)
            }
        
        return {
            'query': query,
            'total_results': len(results),
            'repositories_found': len(repo_results),
            'results_by_repository': enhanced_results
        }
    
    def find_similar_files(self, file_path: str, repo_name: str, limit: int = 10) -> List[Dict]:
        """Find files similar to a specific file"""
        # Get the content of the target file
        repo_info = self.get_repository_info(repo_name)
        if not repo_info:
            return []
        
        try:
            with open(repo_info['data_file'], 'r') as f:
                repo_data = json.load(f)
            
            target_content = None
            for file_data in repo_data['files']:
                if file_data['path'] == file_path:
                    target_content = file_data['content']
                    break
            
            if not target_content:
                return []
            
            # Search for similar content
            return self.search(target_content, limit)
            
        except Exception as e:
            print(f"Error finding similar files: {e}")
            return [] 
