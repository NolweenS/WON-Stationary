@props(['review'])

<div class="bg-white p-6 rounded-xl border border-border shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-beige border border-border flex items-center justify-center text-secondary font-serif font-bold text-lg">
                {{ substr($review->user->name, 0, 1) }}
            </div>
            <div>
                <h4 class="font-medium text-primary text-sm">{{ $review->user->name }}</h4>
                <p class="text-[10px] text-secondary uppercase tracking-widest">{{ $review->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <x-star-rating :rating="$review->rating" />
    </div>

    <p class="text-secondary text-sm leading-relaxed font-light italic">
        "{{ $review->comment }}"
    </p>
</div>
