import os
import git
from pathlib import Path
from typing import List, Dict, Any, Optional
from dataclasses import dataclass
from github import Github
import json
import hashlib
from datetime import datetime

from config import Config

@dataclass
class RepoMetadata:
    name: str
    path: str
    url: str
    last_updated: str
    file_count: int
    languages: Dict[str, int]
    size_mb: float

class LocalRepoProcessor:
    def __init__(self):
        self.config = Config()
        self.github_client = Github(self.config.GITHUB_TOKEN) if self.config.GITHUB_TOKEN else None
        
    def clone_or_update_repo(self, repo_url: str, local_path: Optional[str] = None) -> Path:
        """Clone or update a repository locally"""
        repo_name = repo_url.split('/')[-1].replace('.git', '')
        
        if local_path:
            repo_path = Path(local_path)
        else:
            repo_path = self.config.REPOS_DIR / repo_name
            
        if repo_path.exists():
            print(f"Updating existing repo: {repo_name}")
            repo = git.Repo(repo_path)
            repo.remotes.origin.pull()
        else:
            print(f"Cloning repo: {repo_name}")
            git.Repo.clone_from(repo_url, repo_path)
            
        return repo_path
    
    def scan_local_directory(self, directory_path: str) -> Path:
        """Scan an existing local directory as a repository"""
        repo_path = Path(directory_path)
        if not repo_path.exists():
            raise ValueError(f"Directory does not exist: {directory_path}")
        return repo_path
    
    def extract_files_content(self, repo_path: Path) -> List[Dict[str, Any]]:
        """Extract content from all supported files in the repository"""
        files_data = []
        
        for file_path in repo_path.rglob('*'):
            if self._should_process_file(file_path):
                try:
                    content = self._read_file_content(file_path)
                    if content:
                        files_data.append({
                            'path': str(file_path.relative_to(repo_path)),
                            'full_path': str(file_path),
                            'content': content,
                            'extension': file_path.suffix,
                            'size': file_path.stat().st_size,
                            'modified': datetime.fromtimestamp(file_path.stat().st_mtime).isoformat(),
                            'hash': hashlib.md5(content.encode()).hexdigest()
                        })
                except Exception as e:
                    print(f"Error processing {file_path}: {e}")
                    
        return files_data
    
    def _should_process_file(self, file_path: Path) -> bool:
        """Check if file should be processed"""
        if not file_path.is_file():
            return False
            
        # Check if in ignored directory
        for part in file_path.parts:
            if part in self.config.IGNORE_DIRS:
                return False
                
        # Check file extension
        if file_path.suffix not in self.config.SUPPORTED_EXTENSIONS:
            return False
            
        # Check file size (skip very large files)
        try:
            if file_path.stat().st_size > 1024 * 1024:  # 1MB limit
                return False
        except:
            return False
            
        return True
    
    def _read_file_content(self, file_path: Path) -> Optional[str]:
        """Read file content with encoding detection"""
        encodings = ['utf-8', 'latin-1', 'cp1252']
        
        for encoding in encodings:
            try:
                with open(file_path, 'r', encoding=encoding) as f:
                    return f.read()
            except UnicodeDecodeError:
                continue
            except Exception as e:
                print(f"Error reading {file_path}: {e}")
                break
                
        return None
    
    def generate_repo_metadata(self, repo_path: Path, files_data: List[Dict]) -> RepoMetadata:
        """Generate metadata for the repository"""
        languages = {}
        total_size = 0
        
        for file_data in files_data:
            ext = file_data['extension']
            size = file_data['size']
            
            if ext not in languages:
                languages[ext] = 0
            languages[ext] += 1
            total_size += size
        
        return RepoMetadata(
            name=repo_path.name,
            path=str(repo_path),
            url=self._get_repo_url(repo_path),
            last_updated=datetime.now().isoformat(),
            file_count=len(files_data),
            languages=languages,
            size_mb=total_size / (1024 * 1024)
        )
    
    def _get_repo_url(self, repo_path: Path) -> str:
        """Get repository URL from git config"""
        try:
            repo = git.Repo(repo_path)
            return repo.remotes.origin.url
        except:
            return f"local:{repo_path}"
    
    def save_processed_data(self, repo_metadata: RepoMetadata, files_data: List[Dict]) -> str:
        """Save processed repository data to JSON"""
        data = {
            'metadata': repo_metadata.__dict__,
            'files': files_data
        }
        
        filename = f"{repo_metadata.name}_{datetime.now().strftime('%Y%m%d_%H%M%S')}.json"
        filepath = self.config.DATA_DIR / filename
        
        with open(filepath, 'w') as f:
            json.dump(data, f, indent=2)
            
        return str(filepath)
    
    def process_repository(self, repo_source: str, is_url: bool = True) -> Dict[str, Any]:
        """Main method to process a repository"""
        print(f"Processing repository: {repo_source}")
        
        if is_url:
            repo_path = self.clone_or_update_repo(repo_source)
        else:
            repo_path = self.scan_local_directory(repo_source)
        
        print("Extracting files content...")
        files_data = self.extract_files_content(repo_path)
        
        print("Generating metadata...")
        metadata = self.generate_repo_metadata(repo_path, files_data)
        
        print("Saving processed data...")
        data_file = self.save_processed_data(metadata, files_data)
        
        result = {
            'metadata': metadata,
            'files_processed': len(files_data),
            'data_file': data_file,
            'repo_path': str(repo_path)
        }
        
        print(f"✅ Repository processed successfully!")
        print(f"   Files processed: {len(files_data)}")
        print(f"   Data saved to: {data_file}")
        
        return result 
