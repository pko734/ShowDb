@extends('layouts.master')
@section('title')
{{ $heading }}
@endsection
@section('content')
<div class="panel panel-default container">
	<div class="panel-heading row">
    	<div class="col-lg-6 col-md-6">
      		<h1>{{ $heading }}</h1>
      		<p><em>{!! $subheader !!}</em></p>
    	</div>
    	<div class="col-lg-6 col-md-6" style="margin-top: 20px">
			@if($user && $user->admin && $category)
				<span class="input-group-btn" style="vertical-align:top;">
					<button id="merchaddbutton" type="button" class="btn btn-default">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
			</span>
			@endif
	    </div>
	</div>

    <div class="row">
        <div class="col-lg-12 col-md-12" style="margin-top: 10px; margin-bottom: 15px;">
			@if($user)
			<a href="/merch">My Merch</a>
			@endif
			|
			@foreach($allCategories as $c)
				<a href="/merch/{{ strtolower($c) }}">
				{{ implode(" ", preg_split('/(?=[A-Z])/', ucwords($c))) }}
				</a>
			|
			@endforeach
	    </div>
	</div>

	<div class="panel-body">
		<div class="col-md-6">
			<div class="row">
				<form id="add-merch-form" action="/merch" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					@if($category)
					<input type="hidden" name="category" value="{{ $category }}">
					@endif
				</form>
			</div>
		</div>
	</div>

	<div class="panel-body">
     	<div class="col-xs-12">
		 	<div class="row display-flex">
				@forelse($merch as $m)
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-2">
					<div id="thumbnail-{{ $m->id }}" class="thumbnail panel-shadow @if($m->userHas()->count()) got-it @endif @if($m->userWants()->count()) want-it @endif">
						<div class="caption text-center">
							<div style="overflow: hidden; text-overflow: clip; white-space: nowrap">
								<strong>Category: {{ implode(" ", preg_split('/(?=[A-Z])/', ucwords($m->category))) }}</strong>
							</div>
                            @if($m->shows()->first())
                            <div style="overflow: hidden; text-overflow: clip; white-space: nowrap">
                            @if($user && $m->shows()->first()->users->contains($user->id))
                                <a data-toggle="tooltip"
                                    data-placement="top"
                                    title="I was there">
                                <i style="color: green;"
                                    class="far fa-check-square"
                                    aria-hidden="true"></i>
                                </a>
                            @endif
                            <a href="/shows/{{ $m->shows()->first()->id }}">
                            {{ $m->shows()->first()->getShowDisplay() }}
                            </a>
                            </div>
                            @endif
						</div>

						<a target="_merch"
							data-gallery
							title="{{ $m->title() }}"
							href="{{ $m->url }}"
							text="text/html">

							<img src="{{ $m->thumbnail_url }}"/>
						</a>

						<div class="caption text-center">
							@if($m->artists()->first())
							<a href="/merch/posters?selector=artist&artist_id={{ $m->artists()->first()->id }}">
							@endif
							{{ $m->artist }}
							@if($m->artists()->first())
							</a>
							@endif
							@if($m->name)
							{{ $m->name }}
							@endif
                            @if($m->description)
                            <br/>
                            <span style="font-size: smaller">{{ $m->description }}</span>
                            @endif
                            @if($m->notes)
                            <br/>
                            <span style="font-size: smaller">{{ $m->notes }}</span>
                            @endif
							<br/>

							@if($user)
							<span class="text-left">
								<a class="merch-claimer" href="#" data-target="merch_{{ $m->id }}">
									<i style="color: grey;" class="fas fa-ellipsis-h" aria-hidden="true"></i>
								</a>
								<div id="merch_{{ $m->id }}" class="hidden">
									<a href="#" class="claim-mine" data-merch-id="{{ $m->id }}" data-merch-status="{{ $m->userHas()->count() }}">
										<i id="claim-mine-{{ $m->id }}" class="far @if($m->userHas()->count() == 1) fa-check-square @else fa-square @endif" aria-hidden="true">
											In my collection
										</i>
									</a>
									<br>
									<a href="#" class="claim-want" data-merch-id="{{ $m->id }}"  data-merch-status="{{ $m->userWants()->count() }}">
										<i id="claim-want-{{ $m->id }}" class="far @if($m->userWants()->count() == 1) fa-check-square @else fa-square @endif" aria-hidden="true">
											On my wishlist
										</i>
									</a>
									@if($user && $user->admin && $category != '')
									<div class="caption">
										<span class="input-group-btn" style="vertical-align:top;">
											<a href="/merch/{{ $m->id }}/edit">
												<button type="button" class="edit-merch-btn btn btn-default">
													<span class="glyphicon glyphicon-edit"></span>
												</button>
											</a>
											<button type="button"
													class="delete-merch-btn btn pull-right btn-danger"
													data-merch-id="{{ $m->id }}"
													data-merch-category="{{ $m->category}}">
												<span class="glyphicon glyphicon-trash"></span>
											</button>
										</span>
									</div>
									@endif
								</div>
							</span>
							@endif
						</div>
					</div>
				</div>
				@empty
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-2">
					<h2>@if($category) No merch in this category yet @else You haven't added any merch yet! @endif</h2>
				</div>
				@endforelse
			</div><!-- row display-flex -->
    	</div><!--/.is-table-col-->
	</div><!--/.is-table-->

  	<div class="panel-footer row">
    	{!! $merch->render() !!}
  	</div><!--/.panel-footer-->
</div><!--/.panel-->

<form id="delete-merch-form" method="POST" action="#">
  {{ csrf_field() }}
  {{ method_field('DELETE') }}
</form>
<form method="POST" id="user-add-merch-form" action="">
  {{ csrf_field() }}
  <input id="user-merch-claim-mode" type="hidden" name="mode" value="">
</form>
<form method="POST" id="user-remove-merch-form" action="">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

@endsection
