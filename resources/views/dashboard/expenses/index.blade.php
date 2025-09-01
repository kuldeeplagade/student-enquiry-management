@extends('dashboard')

@section('content')
<div class="container">
    <h3 class="mb-3 d-flex align-items-center">
        <i class="bi bi-cash-coin text-dark fs-4 me-2"></i> Expense Summary
    </h3>


    {{-- Manage Categories Button --}}
    <div class="d-flex justify-content-between align-items-center  mb-3 gap-2 flex-wrap">
    <a href="{{ route('expenses.create') }}" class="btn btn-success ">
        <i class="bi bi-plus-circle"></i> Add Expense
    </a>
        <button class="btn btn-outline-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#manageCategoriesModal">
            <i class="bi bi-tags-fill"></i> Manage Categories
        </button>
    </div>

    @php  
        $monthName = \Carbon\Carbon::createFromDate(null, $currentMonth)->format('F');
    @endphp

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-0 text-dark">
                <strong>Total Expenses for {{ $monthName }} (₹):</strong> {{ number_format($total, 2) }}
            </h5>
        </div>
    </div>


    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle text-center">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Amount (₹)</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $expense)
                            <tr>
                                <td>{{ ($expenses->currentPage() - 1) * $expenses->perPage() + $loop->iteration }}</td>
                                <td>{{ $expense->title }}</td>
                                <td>₹{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->category->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                <td>{{ $expense->notes }}</td>
                                <td>
                                    <a href="{{ route('expenses.edit', $expense->id) }}" 
                                       class="btn btn-sm custom-btn edit-btn me-1 mb-1">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>

                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm custom-btn delete-btn mb-1">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-emoji-frown fs-4 me-2"></i> No expenses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        @include('components.shared-pagination', ['paginator' => $expenses])
    </div>
</div>

<!-- Manage Categories Modal -->
<div class="modal fade" id="manageCategoriesModal" tabindex="-1" aria-labelledby="manageCategoriesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="manageCategoriesLabel"><i class="bi bi-tags"></i> Manage Expense Categories</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Success Message (Shows near list) -->
        <div id="categorySuccess" class="alert alert-success d-none mb-3" role="alert"></div>

        <!-- Add Category Form -->
        <form id="addCategoryForm" class="d-flex mb-3 gap-2">
          @csrf
          <input type="text" id="newCategoryInput" name="name" class="form-control" placeholder="Enter category name" required>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
            <i class="bi bi-plus-circle"></i> Add
          </button>
        </form>

        <!-- Category List -->
        <ul class="list-group" id="categoryList">
          @foreach ($categories->sortByDesc('created_at') as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center gap-2" data-id="{{ $category->id }}">
            <span class="category-name">{{ $category->name }}</span>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-transparent text-warning edit-btn me-2"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-transparent text-danger delete-btn"><i class="bi bi-trash"></i></button>
            </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Design Styling -->
<style>
    .custom-btn {
      color: #fff;
      border-radius: 6px;
      padding: 6px 12px;
      font-size: 0.875rem;
      transition: background-color 0.3s ease;
  }

  .edit-btn {
      background-color: #f0ad4e;
  }

  .edit-btn:hover {
      background-color: #e0962f;
  }

  .delete-btn {
      background-color: #d9534f;
  }

  .delete-btn:hover {
      background-color: #c9302c;
  }

  #manageCategoriesModal .btn-transparent {
  background-color: transparent;
  border: 1px solid #ced4da; /* Light border */
  padding: 5px 8px;
  font-size: 0.875rem;
  border-radius: 0.25rem;
  transition: background-color 0.2s ease, border-color 0.2s ease;
}

  #manageCategoriesModal .btn-transparent:hover {
    background-color: rgba(0, 0, 0, 0.05);
    border-color: #6c757d; /* Darker border on hover */
  }

  #manageCategoriesModal .edit-form input {
    flex: 1;
  }

  #manageCategoriesModal .btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #manageCategoriesModal .category-item:hover {
    background-color: #f9f9f9;
  }

  #manageCategoriesModal .list-group-item {
    transition: background-color 0.2s ease;
  }

  #manageCategoriesModal #category-success {
    font-size: 0.85rem;
    padding: 8px 12px;
  }

</style>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('addCategoryForm');
  const input = document.getElementById('newCategoryInput');
  const list = document.getElementById('categoryList');
  const successAlert = document.getElementById('categorySuccess');

  function showMessage(message, isError = false) {
    successAlert.textContent = message;
    successAlert.classList.remove('d-none', 'alert-success', 'alert-danger');
    successAlert.classList.add(isError ? 'alert-danger' : 'alert-success');
    setTimeout(() => successAlert.classList.add('d-none'), 3500);
  }

  // Add Category
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const name = input.value.trim();
    if (!name) return;

    const response = await fetch(`{{ route('expense-categories.store') }}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ name })
    });

    const data = await response.json();
    if (response.ok) {
      const li = document.createElement('li');
      li.className = 'list-group-item d-flex justify-content-between align-items-center gap-2';
      li.dataset.id = data.id;
      li.innerHTML = `
        <span class="category-name">${data.name}</span>
        <div class="btn-group btn-group-sm">
          <button class="btn btn-transparent text-warning edit-btn me-2">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-transparent text-danger delete-btn">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      `;
      list.prepend(li);
      input.value = '';
      showMessage('Category added successfully.');
    } else {
      showMessage(data.message || 'Category already exists.', true);
    }
  });

  // Edit Category
  list.addEventListener('click', (e) => {
    const editBtn = e.target.closest('.edit-btn');
    if (editBtn) {
      const li = editBtn.closest('li');
      const span = li.querySelector('.category-name');
      if (span.querySelector('form')) return;
      const oldName = span.textContent.trim();

      span.innerHTML = `
        <form class="edit-form d-flex gap-2 w-100 align-items-center">
          <input type="text" class="form-control form-control-sm" value="${oldName}" required>
          <button class="btn btn-success btn-sm icon-btn" type="submit">
            <i class="bi bi-save"></i>
          </button>
        </form>
      `;

      const form = span.querySelector('.edit-form');
      form.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        const newName = form.querySelector('input').value.trim();
        const id = li.dataset.id;

        const response = await fetch(`/expense-categories/${id}`, {
          method: 'PUT',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ name: newName })
        });

        const data = await response.json();
        if (response.ok) {
          span.innerHTML = newName;
          showMessage('Category updated successfully.');
        } else {
          showMessage(data.message || 'Error updating category.', true);
        }
      });
    }
  });

  // Delete Category
  list.addEventListener('click', async (e) => {
    const deleteBtn = e.target.closest('.delete-btn');
    if (deleteBtn) {
      e.preventDefault();
      const li = deleteBtn.closest('li');
      const id = li.dataset.id;

      if (!confirm('Are you sure you want to delete this category?')) return;

      const response = await fetch(`/expense-categories/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      });

      const data = await response.json();
      if (response.ok) {
        li.remove();
        showMessage('Category deleted successfully.');
      } else {
        showMessage(data.message || 'Unable to delete category.', true);
      }
    }
  });
});
</script>

@endsection
