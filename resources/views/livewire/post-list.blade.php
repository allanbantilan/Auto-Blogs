<div class=" px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="text-gray-600">
            @if($this->activeCategory || $search)
            <button class="gray-500 text-xs mr-3" wire:click="clearFilters">X</button>
            @endif
     
            @if ($this->activeCategory)
                <x-badge wire:navigate href="{{ route('posts.index', ['category' => $this->activeCategory->slug]) }}"
                    textColor="{{ $this->activeCategory->text_color }}" bgColor="{{ $this->activeCategory->bg_color }}">
                    {{ $this->activeCategory->title }}
                </x-badge>
            @endif

            @if ($search)
                <span class="m-l-2">
                    Containing : <strong>{{ $search }}</strong>
                </span>
            @endif


        </div>
        <div class="flex items-center space-x-4 font-light ">
          
            <x-checkbox wire:model.live="popular" />
            <x-label> Popular </x-label>

            <button
            class="{{ $sort === 'desc' ? 'text-gray-900 py-4 border-b border-gray-700' : 'text-gray-500 ' }} py-4 {{ $popular ? 'cursor-not-allowed opacity-50' : '' }}"
            wire:click="setSort('desc')"
            @if($popular) disabled @endif>Latest</button>
        
        <button
            class="{{ $sort === 'asc' ? 'text-gray-900 py-4 border-b border-gray-700' : 'text-gray-500 ' }} py-4 {{ $popular ? 'cursor-not-allowed opacity-50' : '' }}"
            wire:click="setSort('asc')"
            @if($popular) disabled @endif>Oldest</button>
        </div>
    </div>
    <div class="py-4">
        @foreach ($this->posts as $post)
            <x-posts.post-item :key="$post->id" :post="$post" />
        @endforeach
    </div>

    <div class="my-3">
        {{ $this->posts->onEachSide(1)->links() }}
    </div>

</div>
