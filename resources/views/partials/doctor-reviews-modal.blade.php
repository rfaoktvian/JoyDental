@forelse ($doctor->reviews as $review)
    <div class="review-item d-flex gap-3 p-3 rounded-3 mb-3 shadow-sm bg-white hover-shadow-sm">
        <img src="{{ asset('images/doctors_dashboard.png') }}" alt="User Photo" class="rounded-circle" width="48"
            height="48" style="object-fit: cover;">
        <div class="w-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong class="text-dark">User #{{ $review->user_id }}</strong>
                    <div class="small text-muted">{{ $review->created_at->format('d M Y') }}</div>
                </div>
                <div class="text-warning d-flex align-items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }} me-1"></i>
                    @endfor
                    <span class="ms-1 text-dark fw-semibold">{{ $review->rating }} / 5</span>
                </div>
            </div>
            <p class="mt-2 mb-0 text-muted lh-sm">{{ $review->comment }}</p>
        </div>
    </div>
@empty
    <div class="text-center text-muted py-4">
        <i class="fas fa-info-circle me-1"></i>Belum ada ulasan untuk dokter ini.
    </div>
@endforelse
