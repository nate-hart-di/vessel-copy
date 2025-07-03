import streamlit as st
import json
import plotly.express as px
import plotly.graph_objects as go
from typing import Dict, List, Any
import pandas as pd
from datetime import datetime
import networkx as nx
from pathlib import Path

from knowledge_graph import LocalKnowledgeGraph
from config import Config

class KnowledgeGraphInterface:
    def __init__(self):
        self.config = Config()
        self.kg = LocalKnowledgeGraph()
        
    def run(self):
        """Main Streamlit interface"""
        st.set_page_config(
            page_title="Local Knowledge Graph",
            page_icon="🧠",
            layout="wide"
        )
        
        st.title("🧠 Local Repository Knowledge Graph")
        st.markdown("**Private, Local, Secure** - Your code stays on your machine")
        
        # Sidebar for navigation
        st.sidebar.title("Navigation")
        page = st.sidebar.selectbox(
            "Choose a page",
            ["Dashboard", "Add Repository", "Search", "Repository Management", "Analytics"]
        )
        
        if page == "Dashboard":
            self.dashboard_page()
        elif page == "Add Repository":
            self.add_repository_page()
        elif page == "Search":
            self.search_page()
        elif page == "Repository Management":
            self.repository_management_page()
        elif page == "Analytics":
            self.analytics_page()
    
    def dashboard_page(self):
        """Dashboard showing overview of the knowledge graph"""
        st.header("📊 Dashboard")
        
        # Get stats
        stats = self.kg.get_stats()
        
        # Main metrics
        col1, col2, col3, col4 = st.columns(4)
        with col1:
            st.metric("Total Repositories", stats['total_repositories'])
        with col2:
            st.metric("Total Files", stats['total_files'])
        with col3:
            st.metric("Vector Documents", stats['total_documents'])
        with col4:
            st.metric("Vector Dimensions", stats['vector_size'])
        
        # Recent repositories
        st.subheader("📚 Recent Repositories")
        if stats['repositories']:
            repos_df = pd.DataFrame(stats['repositories'])
            repos_df['processed_at'] = pd.to_datetime(repos_df['processed_at'])
            repos_df = repos_df.sort_values('processed_at', ascending=False)
            st.dataframe(repos_df, use_container_width=True)
        else:
            st.info("No repositories added yet. Go to 'Add Repository' to get started!")
        
        # Language distribution
        if stats['languages']:
            st.subheader("💻 Language Distribution")
            lang_df = pd.DataFrame(
                [(lang, count) for lang, count in stats['languages'].items()],
                columns=['Language', 'Files']
            )
            fig = px.pie(lang_df, values='Files', names='Language', title="Files by Language")
            st.plotly_chart(fig, use_container_width=True)
    
    def add_repository_page(self):
        """Page for adding new repositories"""
        st.header("➕ Add Repository")
        
        # Repository source selection
        source_type = st.radio(
            "Repository Source",
            ["GitHub URL", "Local Directory"]
        )
        
        if source_type == "GitHub URL":
            repo_url = st.text_input(
                "GitHub Repository URL",
                placeholder="https://github.com/username/repository"
            )
            custom_name = st.text_input(
                "Custom Repository Name (optional)",
                placeholder="Leave empty to use repository name"
            )
            
            if st.button("Add Repository") and repo_url:
                with st.spinner("Processing repository..."):
                    try:
                        result = self.kg.add_repository(
                            repo_url,
                            custom_name if custom_name else None,
                            is_url=True
                        )
                        st.success(f"✅ Repository '{result['repo_name']}' added successfully!")
                        st.json(result)
                    except Exception as e:
                        st.error(f"❌ Error adding repository: {str(e)}")
        
        else:  # Local Directory
            local_path = st.text_input(
                "Local Directory Path",
                placeholder="/path/to/your/local/repository"
            )
            custom_name = st.text_input(
                "Repository Name",
                placeholder="my-local-repo"
            )
            
            if st.button("Add Local Repository") and local_path and custom_name:
                with st.spinner("Processing local repository..."):
                    try:
                        result = self.kg.add_repository(
                            local_path,
                            custom_name,
                            is_url=False
                        )
                        st.success(f"✅ Repository '{result['repo_name']}' added successfully!")
                        st.json(result)
                    except Exception as e:
                        st.error(f"❌ Error adding repository: {str(e)}")
    
    def search_page(self):
        """Page for searching the knowledge graph"""
        st.header("🔍 Search Knowledge Graph")
        
        # Search interface
        query = st.text_input(
            "Search Query",
            placeholder="Enter your search query..."
        )
        
        col1, col2 = st.columns(2)
        with col1:
            limit = st.slider("Max Results", 1, 50, 10)
        with col2:
            # Repository filter
            repos = self.kg.list_repositories()
            repo_names = ["All Repositories"] + [repo['name'] for repo in repos]
            repo_filter = st.selectbox("Filter by Repository", repo_names)
        
        if st.button("Search") and query:
            with st.spinner("Searching..."):
                filter_repo = None if repo_filter == "All Repositories" else repo_filter
                results = self.kg.search(query, limit, filter_repo)
                
                if results:
                    st.subheader(f"📊 Found {len(results)} results")
                    
                    for i, result in enumerate(results, 1):
                        with st.expander(f"Result {i}: {result['path']} (Score: {result['score']:.3f})"):
                            st.write(f"**Repository:** {result['repo_name']}")
                            st.write(f"**File:** {result['path']}")
                            st.write(f"**Extension:** {result['extension']}")
                            st.write(f"**Size:** {result['size']} bytes")
                            st.write("**Content Preview:**")
                            st.code(result['content'][:500] + "..." if len(result['content']) > 500 else result['content'])
                else:
                    st.info("No results found for your query.")
        
        # Enhanced search with context
        st.subheader("🎯 Semantic Search with Context")
        if st.button("Enhanced Search") and query:
            with st.spinner("Performing enhanced search..."):
                context_results = self.kg.semantic_search_with_context(query, limit=5)
                
                if context_results['results_by_repository']:
                    st.write(f"**Query:** {context_results['query']}")
                    st.write(f"**Total Results:** {context_results['total_results']}")
                    st.write(f"**Repositories Found:** {context_results['repositories_found']}")
                    
                    for repo_name, repo_data in context_results['results_by_repository'].items():
                        st.subheader(f"📁 {repo_name} (Relevance: {repo_data['relevance_score']:.3f})")
                        
                        for file_result in repo_data['matching_files']:
                            with st.expander(f"{file_result['path']} (Score: {file_result['score']:.3f})"):
                                st.code(file_result['content'][:300] + "..." if len(file_result['content']) > 300 else file_result['content'])
    
    def repository_management_page(self):
        """Page for managing repositories"""
        st.header("📁 Repository Management")
        
        repos = self.kg.list_repositories()
        
        if not repos:
            st.info("No repositories found. Add some repositories first!")
            return
        
        # Repository list
        st.subheader("📚 Your Repositories")
        
        for repo in repos:
            col1, col2, col3, col4 = st.columns([3, 1, 1, 1])
            
            with col1:
                st.write(f"**{repo['name']}**")
                st.write(f"Source: {repo['source']}")
                st.write(f"Files: {repo['files_processed']}")
                st.write(f"Added: {repo['processed_at'][:10]}")
            
            with col2:
                if st.button(f"Update", key=f"update_{repo['name']}"):
                    with st.spinner(f"Updating {repo['name']}..."):
                        try:
                            result = self.kg.update_repository(repo['name'])
                            st.success(f"✅ {repo['name']} updated!")
                            st.experimental_rerun()
                        except Exception as e:
                            st.error(f"❌ Error: {str(e)}")
            
            with col3:
                if st.button(f"Info", key=f"info_{repo['name']}"):
                    info = self.kg.get_repository_info(repo['name'])
                    st.json(info)
            
            with col4:
                if st.button(f"Remove", key=f"remove_{repo['name']}"):
                    if st.confirm(f"Remove {repo['name']}?"):
                        self.kg.remove_repository(repo['name'])
                        st.success(f"✅ {repo['name']} removed!")
                        st.experimental_rerun()
            
            st.divider()
    
    def analytics_page(self):
        """Page showing analytics and insights"""
        st.header("📈 Analytics")
        
        stats = self.kg.get_stats()
        
        if not stats['repositories']:
            st.info("No data available. Add some repositories first!")
            return
        
        # Repository size comparison
        st.subheader("📊 Repository Comparison")
        repos_data = []
        for repo in stats['repositories']:
            repos_data.append({
                'Repository': repo['name'],
                'Files': repo['files_processed'],
                'Added': repo['processed_at'][:10]
            })
        
        repos_df = pd.DataFrame(repos_data)
        fig = px.bar(repos_df, x='Repository', y='Files', title="Files per Repository")
        st.plotly_chart(fig, use_container_width=True)
        
        # Language trends
        if stats['languages']:
            st.subheader("💻 Language Analysis")
            
            # Top languages
            lang_data = sorted(stats['languages'].items(), key=lambda x: x[1], reverse=True)[:10]
            lang_df = pd.DataFrame(lang_data, columns=['Language', 'Count'])
            
            fig = px.bar(lang_df, x='Language', y='Count', title="Top 10 Languages")
            st.plotly_chart(fig, use_container_width=True)
        
        # Vector store statistics
        st.subheader("🔍 Vector Store Statistics")
        col1, col2 = st.columns(2)
        
        with col1:
            st.metric("Vector Dimensions", stats['vector_size'])
            st.metric("Distance Metric", stats['distance_metric'])
        
        with col2:
            st.metric("Total Documents", stats['total_documents'])
            st.metric("Storage Efficiency", f"{stats['total_documents']/stats['total_files']:.2f}" if stats['total_files'] > 0 else "N/A")
        
        # Export functionality
        st.subheader("📤 Export Data")
        if st.button("Export Knowledge Graph"):
            export_path = self.kg.export_knowledge_graph("knowledge_graph_export.json")
            st.success(f"✅ Exported to: {export_path}")
            
            # Provide download link
            with open(export_path, 'r') as f:
                st.download_button(
                    label="Download Export File",
                    data=f.read(),
                    file_name="knowledge_graph_export.json",
                    mime="application/json"
                )

def main():
    """Main function to run the Streamlit app"""
    interface = KnowledgeGraphInterface()
    interface.run()

if __name__ == "__main__":
    main() 
