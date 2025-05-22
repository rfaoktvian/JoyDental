@props(['testimonials', 'active'])

@props(['testimonials', 'active'])

<div class="carousel-item {{ $active ? 'active' : '' }}">
  <div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($testimonials as $t)
    <div class="col">
      <div class="card shadow-sm h-100" style="height: 250px;">
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center mb-2">
        <img src="{{ asset($t->avatar_path) }}" class="rounded-circle me-3" alt="{{ $t->name }}" width="40"
          height="40">
        <div>
          <h6 class="mb-0 fw-semibold">{{ $t->name }}</h6>
          <small class="text-muted">{{ $t->role }}</small>
        </div>
        </div>
        <hr>
        <p class="flex-grow-1 overflow-auto mb-0">"{{ $t->message }}"</p>
      </div>
      </div>
    </div>
  @endforeach
  </div>
</div>