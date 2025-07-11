@if ($paginator->hasPages())
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <!-- Left side: Showing X to Y of Z -->
        <div class="text-muted ms-2">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <!-- Right side: Pagination links -->
        <div class="d-flex justify-content-end">
            {{ $paginator->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
