# 🧠 Local Knowledge Graph for Private Repositories

A complete local solution for creating knowledge graphs from your private repositories. Everything runs on your machine - your code never leaves your environment.

## ✨ Features

- **🔒 100% Private**: All processing happens locally
- **📊 Multiple Vector Databases**: Qdrant, ChromaDB, LanceDB support
- **🤖 Local Embeddings**: No API calls required for embeddings
- **🔍 Semantic Search**: Advanced similarity search across codebases
- **🌐 Web Interface**: Beautiful Streamlit dashboard
- **⚡ CLI Interface**: Command-line tools for automation
- **📈 Analytics**: Repository insights and language statistics
- **🔄 Auto-Updates**: Keep repositories synchronized
- **📤 Export/Import**: Backup and share knowledge graphs

## 🏗️ Architecture

```
Local Knowledge Graph
├── Repository Processor    # Clone, scan, and process repositories
├── Vector Store           # Local embeddings and similarity search
├── Knowledge Graph        # Orchestrate processing and queries
├── Web Interface          # Streamlit dashboard
└── CLI Interface          # Command-line tools
```

## 🚀 Quick Start

### 1. Installation

```bash
# Clone this repository
git clone <your-repo-url>
cd local_knowledge_graph

# Create virtual environment
python -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate

# Install dependencies
pip install -r requirements.txt
```

### 2. Configuration

```bash
# Copy environment file
cp env.example .env

# Edit .env with your settings
# At minimum, set your GitHub token for private repos
GITHUB_TOKEN=your_github_token_here
```

### 3. Start Vector Database (Optional)

For Qdrant (recommended):

```bash
# Using Docker
docker run -p 6333:6333 qdrant/qdrant

# Or install locally
pip install qdrant-client
```

For ChromaDB or LanceDB, no additional setup needed.

### 4. Launch Web Interface

```bash
streamlit run web_interface.py
```

Visit `http://localhost:8501` to access the dashboard.

### 5. Or Use CLI

```bash
# Add a repository
python cli.py add-repo https://github.com/your-username/your-private-repo

# Search your code
python cli.py search "authentication function"

# Get statistics
python cli.py stats
```

## 📖 Usage Guide

### Adding Repositories

**Web Interface:**

1. Go to "Add Repository" page
2. Choose GitHub URL or Local Directory
3. Enter repository details
4. Click "Add Repository"

**CLI:**

```bash
# GitHub repository
python cli.py add-repo https://github.com/user/repo --name custom-name

# Local directory
python cli.py add-local /path/to/repo --name my-project
```

### Searching

**Web Interface:**

- Use the "Search" page for basic queries
- Try "Enhanced Search" for contextual results

**CLI:**

```bash
# Basic search
python cli.py search "error handling"

# Enhanced search with context
python cli.py enhanced-search "authentication patterns"

# Filter by repository
python cli.py search "database connection" --repo my-project
```

### Repository Management

**Web Interface:**

- Use "Repository Management" page to update/remove repos

**CLI:**

```bash
# List all repositories
python cli.py list

# Update a repository
python cli.py update my-project

# Remove a repository
python cli.py remove my-project
```

## 🛠️ Configuration Options

### Vector Database Options

**Qdrant (Recommended)**

- Best performance and features
- Requires Docker or local installation
- Supports filtering and advanced queries

**ChromaDB**

- Easy setup, no external dependencies
- Good for small to medium datasets
- Persistent storage

**LanceDB**

- Columnar storage, great for analytics
- Fast similarity search
- Good for large datasets

### Embedding Models

**Default: `sentence-transformers/all-MiniLM-L6-v2`**

- Fast and lightweight
- Good general-purpose embeddings
- 384 dimensions

**Alternative Options:**

- `sentence-transformers/all-mpnet-base-v2` (768 dim, better quality)
- `sentence-transformers/code-search-net` (code-specific)
- `sentence-transformers/multi-qa-MiniLM-L6-cos-v1` (Q&A optimized)

### File Processing

**Supported Languages:**

- Python, JavaScript, TypeScript, PHP, Java, C/C++
- Go, Rust, Swift, Kotlin, Scala, Ruby, C#
- HTML, CSS, SCSS, SQL, YAML, JSON, Markdown
- Shell scripts, configuration files

**Ignored Directories:**

- `.git`, `node_modules`, `vendor`, `__pycache__`
- `venv`, `env`, `dist`, `build`, `target`
- `.idea`, `.vscode`

## 🔧 Advanced Usage

### Custom Embedding Models

```python
# In config.py, change:
EMBEDDING_MODEL = "sentence-transformers/your-preferred-model"
```

### Batch Processing

```python
from knowledge_graph import LocalKnowledgeGraph

kg = LocalKnowledgeGraph()

# Process multiple repositories
repos = [
    "https://github.com/user/repo1",
    "https://github.com/user/repo2",
    "/path/to/local/repo"
]

for repo in repos:
    kg.add_repository(repo)
```

### Custom Search Filters

```python
# Search specific file types
results = kg.search("function definition", limit=20)
python_files = [r for r in results if r['extension'] == '.py']

# Search by repository
results = kg.search("API endpoint", repo_filter="my-backend")
```

## 📊 Analytics & Insights

### Repository Statistics

- File count and size distribution
- Language breakdown
- Processing timestamps
- Vector store efficiency

### Search Analytics

- Query performance
- Result relevance scores
- Cross-repository patterns
- Similar file detection

### Export Options

- JSON export of complete knowledge graph
- Repository metadata
- Search result history
- Performance metrics

## 🔒 Privacy & Security

### Data Protection

- **No external API calls** for embeddings (uses local models)
- **No data transmission** to third parties
- **Local vector storage** only
- **Encrypted at rest** (if using encrypted filesystem)

### GitHub Token Security

- Only used for repository cloning
- Never transmitted to external services
- Stored locally in `.env` file
- Can be revoked anytime

### Recommended Security Practices

1. Use environment variables for tokens
2. Restrict GitHub token permissions
3. Regularly rotate access tokens
4. Use encrypted storage for sensitive repos
5. Review processed data before sharing exports

## 🚨 Troubleshooting

### Common Issues

**"No module named 'sentence_transformers'"**

```bash
pip install sentence-transformers
```

**"Connection refused to Qdrant"**

```bash
# Start Qdrant server
docker run -p 6333:6333 qdrant/qdrant

# Or switch to ChromaDB in config.py
VECTOR_DB_TYPE = "chroma"
```

**"Repository not found"**

- Check GitHub token permissions
- Verify repository URL
- Ensure repository exists and is accessible

**"Out of memory during processing"**

- Reduce `CHUNK_SIZE` in config
- Process smaller repositories first
- Use a smaller embedding model

### Performance Optimization

**For Large Repositories:**

1. Increase `CHUNK_SIZE` for better context
2. Use LanceDB for better performance
3. Process during off-peak hours
4. Consider excluding large binary files

**For Many Repositories:**

1. Use Qdrant for better scalability
2. Implement batch processing
3. Monitor disk space usage
4. Regular cleanup of old data

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgments

- Built with patterns from the LLM Apps repository
- Uses Sentence Transformers for embeddings
- Powered by Qdrant, ChromaDB, and LanceDB
- Web interface built with Streamlit

## 📞 Support

- Create an issue for bugs or feature requests
- Check the troubleshooting section first
- Review existing issues before creating new ones

---

**Made with ❤️ for private, secure code analysis**
