import os
from pathlib import Path
from dotenv import load_dotenv

load_dotenv()

class Config:
    # Local paths
    BASE_DIR = Path(__file__).parent
    DATA_DIR = BASE_DIR / "data"
    VECTOR_DB_DIR = BASE_DIR / "vector_db"
    REPOS_DIR = BASE_DIR / "repos"
    
    # Create directories if they don't exist
    DATA_DIR.mkdir(exist_ok=True)
    VECTOR_DB_DIR.mkdir(exist_ok=True)
    REPOS_DIR.mkdir(exist_ok=True)
    
    # Local vector database settings
    VECTOR_DB_TYPE = "qdrant"  # Options: qdrant, chroma, lancedb
    QDRANT_HOST = "localhost"
    QDRANT_PORT = 6333
    
    # Local embedding model (no API calls)
    EMBEDDING_MODEL = "sentence-transformers/all-MiniLM-L6-v2"
    
    # GitHub settings (for private repos)
    GITHUB_TOKEN = os.getenv("GITHUB_TOKEN")
    
    # LLM settings (optional - can work without)
    OPENAI_API_KEY = os.getenv("OPENAI_API_KEY")
    
    # Processing settings
    CHUNK_SIZE = 1000
    CHUNK_OVERLAP = 200
    MAX_TOKENS = 4000
    
    # Supported file types
    SUPPORTED_EXTENSIONS = {
        '.py', '.js', '.ts', '.jsx', '.tsx', '.php', '.java', '.cpp', '.c',
        '.h', '.hpp', '.cs', '.rb', '.go', '.rs', '.swift', '.kt', '.scala',
        '.md', '.txt', '.json', '.yaml', '.yml', '.xml', '.html', '.css',
        '.scss', '.sass', '.less', '.sql', '.sh', '.bash', '.zsh'
    }
    
    # Directories to ignore
    IGNORE_DIRS = {
        '.git', 'node_modules', 'vendor', '__pycache__', '.pytest_cache',
        'venv', 'env', '.env', 'dist', 'build', 'target', '.idea', '.vscode'
    } 
