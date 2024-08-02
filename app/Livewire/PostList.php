<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class PostList extends Component
{
    #[Url()]
    public $sort = 'desc';
    
    #[Url()]
    public $search = '';

    #[Url()]
    public $category = '';

    public $popular = false;
    
   

    public function setSort($sort){
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
        $this->resetPage();
    }

    #[On('search')]
    public function updateSearch($search){
        $this->search = $search;
    }

    public function clearFilters(){
        $this->search='';
        $this->category='';
        $this->resetPage();
    }

    use WithPagination;

    #[Computed()]
    public function posts(){
        return Post::published()
        ->when($this->activeCategory(), function ($query){
            $query->withCategory($this->category);
        })
        ->when($this->popular, function($query) {
            // like count and order by like count
            $query->withCount('likes')
            ->orderBy("likes_count", "desc");
        })
        ->where('title', 'like', "%{$this->search}%")
        ->orderBy('published_at', $this->sort)
        ->paginate(5);
    } 



    

    #[Computed()]
    public function activeCategory() {
        return Category::where('slug', $this->category)->first();
    }

    public function render()
    {
        return view('livewire.post-list');
    }

}
