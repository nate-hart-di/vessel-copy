#!/usr/bin/env python3
"""
Command Line Interface for Local Knowledge Graph
"""

import argparse
import json
import sys
from pathlib import Path
from typing import Optional

from knowledge_graph import LocalKnowledgeGraph
from config import Config

class KnowledgeGraphCLI:
    def __init__(self):
        self.kg = LocalKnowledgeGraph()
        self.config = Config()
    
    def add_repository(self, source: str, name: Optional[str] = None, is_url: bool = True):
        """Add a repository to the knowledge graph"""
        try:
            result = self.kg.add_repository(source, name, is_url)
            print(f"✅ Successfully added repository: {result['repo_name']}")
            print(f"   Files processed: {result['files_processed']}")
            print(f"   Documents added: {result['documents_added']}")
            return True
        except Exception as e:
            print(f"❌ Error adding repository: {str(e)}")
            return False
    
    def search(self, query: str, limit: int = 10, repo_filter: Optional[str] = None):
        """Search the knowledge graph"""
        try:
            results = self.kg.search(query, limit, repo_filter)
            
            if not results:
                print("No results found.")
                return
            
            print(f"Found {len(results)} results:")
            print("-" * 80)
            
            for i, result in enumerate(results, 1):
                print(f"{i}. {result['path']} (Score: {result['score']:.3f})")
                print(f"   Repository: {result['repo_name']}")
                print(f"   Extension: {result['extension']}")
                print(f"   Size: {result['size']} bytes")
                print(f"   Content preview: {result['content'][:100]}...")
                print("-" * 80)
                
        except Exception as e:
            print(f"❌ Error searching: {str(e)}")
    
    def list_repositories(self):
        """List all repositories in the knowledge graph"""
        repos = self.kg.list_repositories()
        
        if not repos:
            print("No repositories found.")
            return
        
        print(f"Found {len(repos)} repositories:")
        print("-" * 80)
        
        for repo in repos:
            print(f"Name: {repo['name']}")
            print(f"Source: {repo['source']}")
            print(f"Files: {repo['files_processed']}")
            print(f"Added: {repo['processed_at']}")
            print("-" * 80)
    
    def get_stats(self):
        """Show knowledge graph statistics"""
        stats = self.kg.get_stats()
        
        print("📊 Knowledge Graph Statistics")
        print("=" * 50)
        print(f"Total Repositories: {stats['total_repositories']}")
        print(f"Total Files: {stats['total_files']}")
        print(f"Total Documents: {stats['total_documents']}")
        print(f"Vector Size: {stats['vector_size']}")
        print(f"Distance Metric: {stats['distance_metric']}")
        
        if stats['languages']:
            print("\n💻 Top Languages:")
            sorted_langs = sorted(stats['languages'].items(), key=lambda x: x[1], reverse=True)
            for lang, count in sorted_langs[:10]:
                print(f"  {lang}: {count} files")
    
    def update_repository(self, repo_name: str):
        """Update a repository in the knowledge graph"""
        try:
            result = self.kg.update_repository(repo_name)
            print(f"✅ Successfully updated repository: {result['repo_name']}")
            print(f"   Files processed: {result['files_processed']}")
            return True
        except Exception as e:
            print(f"❌ Error updating repository: {str(e)}")
            return False
    
    def remove_repository(self, repo_name: str):
        """Remove a repository from the knowledge graph"""
        try:
            success = self.kg.remove_repository(repo_name)
            if success:
                print(f"✅ Successfully removed repository: {repo_name}")
            else:
                print(f"❌ Repository not found: {repo_name}")
            return success
        except Exception as e:
            print(f"❌ Error removing repository: {str(e)}")
            return False
    
    def export_graph(self, output_file: str):
        """Export the knowledge graph to a file"""
        try:
            export_path = self.kg.export_knowledge_graph(output_file)
            print(f"✅ Knowledge graph exported to: {export_path}")
            return True
        except Exception as e:
            print(f"❌ Error exporting: {str(e)}")
            return False
    
    def enhanced_search(self, query: str, limit: int = 5):
        """Perform enhanced search with context"""
        try:
            results = self.kg.semantic_search_with_context(query, limit)
            
            if not results['results_by_repository']:
                print("No results found.")
                return
            
            print(f"🎯 Enhanced Search Results for: '{results['query']}'")
            print(f"Total Results: {results['total_results']}")
            print(f"Repositories Found: {results['repositories_found']}")
            print("=" * 80)
            
            for repo_name, repo_data in results['results_by_repository'].items():
                print(f"\n📁 Repository: {repo_name}")
                print(f"   Relevance Score: {repo_data['relevance_score']:.3f}")
                print(f"   Matching Files: {len(repo_data['matching_files'])}")
                
                for file_result in repo_data['matching_files']:
                    print(f"   • {file_result['path']} (Score: {file_result['score']:.3f})")
                    print(f"     Preview: {file_result['content'][:100]}...")
                print("-" * 40)
                
        except Exception as e:
            print(f"❌ Error in enhanced search: {str(e)}")

def main():
    """Main CLI function"""
    parser = argparse.ArgumentParser(
        description="Local Knowledge Graph CLI",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  # Add a GitHub repository
  python cli.py add-repo https://github.com/user/repo

  # Add a local directory
  python cli.py add-local /path/to/repo --name my-repo

  # Search the knowledge graph
  python cli.py search "authentication function"

  # List all repositories
  python cli.py list

  # Get statistics
  python cli.py stats

  # Update a repository
  python cli.py update my-repo

  # Remove a repository
  python cli.py remove my-repo

  # Export knowledge graph
  python cli.py export output.json

  # Enhanced search
  python cli.py enhanced-search "error handling patterns"
        """
    )
    
    subparsers = parser.add_subparsers(dest='command', help='Available commands')
    
    # Add repository command
    add_parser = subparsers.add_parser('add-repo', help='Add a GitHub repository')
    add_parser.add_argument('url', help='GitHub repository URL')
    add_parser.add_argument('--name', help='Custom repository name')
    
    # Add local directory command
    local_parser = subparsers.add_parser('add-local', help='Add a local directory')
    local_parser.add_argument('path', help='Local directory path')
    local_parser.add_argument('--name', required=True, help='Repository name')
    
    # Search command
    search_parser = subparsers.add_parser('search', help='Search the knowledge graph')
    search_parser.add_argument('query', help='Search query')
    search_parser.add_argument('--limit', type=int, default=10, help='Maximum results')
    search_parser.add_argument('--repo', help='Filter by repository name')
    
    # Enhanced search command
    enhanced_parser = subparsers.add_parser('enhanced-search', help='Enhanced search with context')
    enhanced_parser.add_argument('query', help='Search query')
    enhanced_parser.add_argument('--limit', type=int, default=5, help='Maximum results')
    
    # List repositories command
    subparsers.add_parser('list', help='List all repositories')
    
    # Statistics command
    subparsers.add_parser('stats', help='Show knowledge graph statistics')
    
    # Update repository command
    update_parser = subparsers.add_parser('update', help='Update a repository')
    update_parser.add_argument('name', help='Repository name')
    
    # Remove repository command
    remove_parser = subparsers.add_parser('remove', help='Remove a repository')
    remove_parser.add_argument('name', help='Repository name')
    
    # Export command
    export_parser = subparsers.add_parser('export', help='Export knowledge graph')
    export_parser.add_argument('output', help='Output file path')
    
    args = parser.parse_args()
    
    if not args.command:
        parser.print_help()
        return
    
    cli = KnowledgeGraphCLI()
    
    try:
        if args.command == 'add-repo':
            cli.add_repository(args.url, args.name, is_url=True)
        
        elif args.command == 'add-local':
            cli.add_repository(args.path, args.name, is_url=False)
        
        elif args.command == 'search':
            cli.search(args.query, args.limit, args.repo)
        
        elif args.command == 'enhanced-search':
            cli.enhanced_search(args.query, args.limit)
        
        elif args.command == 'list':
            cli.list_repositories()
        
        elif args.command == 'stats':
            cli.get_stats()
        
        elif args.command == 'update':
            cli.update_repository(args.name)
        
        elif args.command == 'remove':
            cli.remove_repository(args.name)
        
        elif args.command == 'export':
            cli.export_graph(args.output)
        
    except KeyboardInterrupt:
        print("\n❌ Operation cancelled by user")
        sys.exit(1)
    except Exception as e:
        print(f"❌ Unexpected error: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    main() 
