@extends('layouts.app')

@section('title', 'Портфолио')
    
@section('header')
    <?php use App\Core\Settings; ?>

    <header class="header">
        <h1>Портфолио</h1>
        <p class="header__paragraph">
            {!! Settings::get('page_portfolio_text') !!}
        </p>
    </header>
@endsection

@section('content')
    <section class="container">
        @foreach ($projects as $project)
            
        <article class="portfolio-item">
            <div class="portfolio-item__left-column">
                <header class="portfolio-item__header">
                    <h2>
                        {{ $project->name }}
                    </h2>
                    <a class="portfolio-item__link link" href="https://{{ $project->link }}">
                        {{ $project->link }}
                    </a>
                </header>
                <p class="portfolio-item__paragraph">
                    {{ $project->description }}
                </p>
                @if ($project->published_at !== null)  
                <p class="portfolio-item__published_at_text">
                    Закончен: 
                    <strong class="number">
                        {{ date_format( date_create($project->published_at), 'm.Y' ) }}
                    </strong>
                </p>
                @endif
                <footer class="portfolio-item__footer">
                    {{-- <button class="portfolio-item__icon icon icon_heart"></button> --}}
                    @if ($project->source_link !== null)                        
                    <a 
                        class="portfolio-item__icon icon icon_github" 
                        href="{{ $project->source_link }}"
                        >
                    </a>
                    @endif
                </footer>
            </div>
            <div class="portfolio-item__right-column">
                <div class="portfolio-item__image-wrapper portfolio-item__image-wrapper_pc">
                    <picture class="portfolio-item__image">
                        <source
                            media="(max-width: 1024px)"
                            sizes="1px"
                            srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w"
                            >
                        <source
                            media="(min-width: 1025px)" 
                            srcset=""
                            >
                        <img 
                            class="portfolio-item__image" 
                            src="{{ $project->pc_image_path }}"
                            loading="lazy"
                            >
                    </picture>
                </div>
                
                <div class="portfolio-item__image-wrapper portfolio-item__image-wrapper_mobile">
                    <picture class="portfolio-item__image">
                        <source
                            media="(max-width: 1024px)"
                            sizes="1px"
                            srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w"
                            >
                        <source
                            media="(min-width: 1025px)" 
                            srcset=""
                            >
                        <img 
                            class="portfolio-item__image" 
                            src="{{ $project->mobile_image_path }}"
                            loading="lazy"
                            >
                    </picture>
                </div>
            </div>
        </article>

        @endforeach
    </section>
@endsection