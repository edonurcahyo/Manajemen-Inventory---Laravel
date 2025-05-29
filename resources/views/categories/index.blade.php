@extends('layouts.app')

@section('title', 'Categories - CV. Agung')
@section('page-title', 'Category Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Categories List</h5>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> New Category
                </a>
            </div>
            <div class="card-body">
                <!-- Search -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="searchCategories" placeholder="Search categories...">
                    </div>
                </div>

                <!-- Categories Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Name</th>
                                <th>Description</th>
                                <th>Products Count</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories ?? [] as $category)
                            <tr>
                                <!-- <td>{{ $category->id }}</td> -->
                                <td>
                                    <strong>{{ $category->nama_kategori }}</strong>
                                </td>
                                <td>
                                    {{ $category->deskripsi ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $category->products_count ?? 0 }} products</span>
                                </td>
                                <td>{{ $category->created_at ? $category->created_at->format('d M Y') : '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteCategory({{ $category->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-tags fa-3x mb-3"></i>
                                        <p>No categories found</p>
                                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Create First Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($categories) && $categories->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteCategory(categoryId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/categories/${categoryId}`;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Search functionality
document.getElementById('searchCategories').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const categoryName = row.cells[1]?.textContent.toLowerCase() || '';
        const categoryDesc = row.cells[2]?.textContent.toLowerCase() || '';
        
        if (categoryName.includes(searchTerm) || categoryDesc.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection