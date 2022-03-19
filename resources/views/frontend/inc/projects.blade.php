@php
    $projects = \App\Models\Project::orderBy('viewed_number')->where('active', 1)->get();
@endphp
<section class="projects pb-5 pt-5">
    <img class="img1" src="{{ asset('/images/icons/1.png') }}" alt="">
    <img class="img2" src="{{ asset('/images/icons/buildings.png') }}" alt="">
    <div class="container">
        <div class="wow jello" data-wow-offset="200">
            @include('frontend.inc.heading', ['heading' => 'مشاريعنا'])
        </div>
        @if($projects->count() > 0)
        <div class="owl-carousel owl-theme projects_carousel wow fadeInUp" data-wow-offset="300">
            @foreach ($projects as $key => $project)
                <div class="item">
                    <a href="{{ route('frontend.project', $project) }}">
                        <div class="project card">
                            <div class="content">
                                @if($project->photos)
                                    <img src="{{ asset(json_decode($project->photos)[0]) }}" alt="">
                                @else
                                    <img src="{{ asset('/images/project.jpg') }}" alt="">
                                @endif
                                <h3>{{ $project->name }}</h3>
                                <p>
                                    @if(strlen($project->description) > 30)
                                    {{ mb_substr($project->description, 0, 30,'utf-8') . '...' }}
                                    @else
                                    {{ $project->description }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="alert alert-info">لا يوجد مشاريع حاليا</div>
        @endif
    </div>
</section>
