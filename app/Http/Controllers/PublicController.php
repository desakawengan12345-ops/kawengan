<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\Post;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    private function settings(): array
    {
        return SiteSetting::all()->pluck('value', 'key')->toArray();
    }

    public function home()
    {
        $settings = $this->settings();
        $destinations = Destination::where('is_published', true)
            ->latest()
            ->take(4)
            ->get();
        $galleries = Gallery::orderBy('order')
            ->take(6)
            ->get();

        $posts = collect();
        if (SiteSetting::where('key', 'feature_news')->value('value') == '1') {
            $posts = Post::where('is_published', true)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        return view('public.home', compact('settings', 'destinations', 'galleries', 'posts'));
    }

    public function destinations()
    {
        $destinations = Destination::where('is_published', true)
            ->latest()
            ->get();

        return view('public.destinations', compact('destinations'));
    }

    public function destinationDetail($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $images = $destination->images()->orderBy('order')->get();

        return view('public.destination-detail', compact('destination', 'images'));
    }

    public function gallery()
    {
        $galleries = Gallery::orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        return view('public.gallery', compact('galleries'));
    }

    public function about()
    {
        $settings = $this->settings();
        return view('public.about', compact('settings'));
    }

    public function contact()
    {
        $settings = $this->settings();
        return view('public.contact', compact('settings'));
    }

    public function news()
    {
        $isNewsEnabled = SiteSetting::where('key', 'feature_news')->value('value');
        if (!$isNewsEnabled) abort(404);

        $posts = Post::where('is_published', true)
            ->latest('published_at')
            ->get();

        return view('public.news', compact('posts'));
    }

    public function newsDetail($slug)
    {
        $isNewsEnabled = SiteSetting::where('key', 'feature_news')->value('value');
        if (!$isNewsEnabled) abort(404);

        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.news-detail', compact('post'));
    }
}
