<!doctype html>
<html lang="fr">
<head>
    @include('inc-meta')
    <title>{{ config('app.name') }} | {{ ucfirst(__('console')) }}</title>
</head>
<body>
    @php
		$lang_switch = '<a href="/console/lang/fr" class="kbd mr-1">fr</a><a href="/console/lang/en" class="kbd">en</a>';
	@endphp
    @include('inc-nav-console')

	<div class="container mt-4 mb-5">

		<div class="row pt-3">

			<div class="col-md-2">
                <a class="btn btn-primary btn-sm mb-4" href="{{route('puzzle-creer-get')}}" role="button" style="width:100%;">{{__('nouveau puzzle')}}</a>
                <a href="https://github.com/txtpuzzle/www.txtpuzzle.net/discussions" target="_blank" role="button" class="mt-2 btn btn-light btn-sm text-left text-muted" style="width:100%;opacity:0.8;">
                	<span style="font-size:80%"><i class="fas fa-comment-alt" style="float:left;margin:4px 8px 5px 0px;"></i> {{__('discussions')}} <span style="opacity:0.6;font-size:90%;">&</span> {{__('annonces')}}</span>
                </a>
                <a href="https://github.com/txtpuzzle/www.txtpuzzle.net/issues" target="_blank" role="button"  class="mt-1 btn btn-light text-left btn-sm text-muted" style="width:100%;opacity:0.8;">
                	<span style="font-size:80%"><i class="fas fa-bug" style="float:left;margin:4px 8px 5px 0px;"></i> {{__('signalement de bogue')}} <span style="opacity:0.6;font-size:90%;">&</span> {{__('questions techniques')}}</span>
                </a>
                <div class="mt-3 text-muted text-monospace pl-1 mb-5" style="font-size:70%;opacity:0.8;">
                	<span><i class="fa fa-envelope"></i> contact@txtpuzzle.net</span>
                </div>
            </div>

			<div class="col-md-10 pl-3 pr-3">

				@if (session('status'))
					<div class="text-success text-monospace text-center pb-4" role="alert">
						{{ session('status') }}
					</div>
				@endif

                <?php
                $puzzles = App\Models\Auth_puzzle::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
                ?>

                @foreach($puzzles as $puzzle)
                    <div id="frame_{{$loop->iteration}}" class="frame">

                        <div class="row">

                            <div class="col-md-12 text-monospace text-muted">
                                <!-- options -->
    							<div style="float:right;">

                                    <a class='btn btn-light btn-sm' data-toggle="collapse" href="#collapse-{{$loop->iteration}}" role='button' aria-expanded="false" aria-controls="collapse-{{$loop->iteration}}" ><i class="fas fa-bars" style="margin-top:0px;" data-toggle="tooltip" data-placement="top" title="{{__('déplier plier')}}"></i></a>

    								<a class='btn btn-light btn-sm' href='/console/puzzle-modifier/{{ Crypt::encryptString($puzzle->id) }}' role='button'><i class="fas fa-pen" data-toggle="tooltip" data-placement="top" title="{{__('modifier')}}"></i></a>

                                    <a tabindex='0' id='/console/puzzle-supprimer/{{ Crypt::encryptString($puzzle->id) }}' class='btn btn-danger btn-sm text-light' role='button'  style="cursor:pointer;outline:none;" data-toggle="popover" data-trigger="focus" data-placement="left" data-html="true" data-content="<a href='/console/puzzle-supprimer/{{ Crypt::encryptString($puzzle->id) }}' class='btn btn-danger btn-sm text-light' role='button'>{{__('confirmer')}}</a><a class='btn btn-light btn-sm ml-2' href='#' role='button'>{{__('annuler')}}</a>"><i class='fas fa-trash fa-sm' data-toggle="tooltip" data-placement="top" title="{{__('supprimer')}}"></i></a>

    							</div>
    							<!-- /options -->

                                <h2 class="p-0 m-0">{{ $puzzle->titre_enseignant }}</h2>
                                <div class="text-monospace small" style="color:silver;">{{ $puzzle->sous_titre_enseignant }}</div>

                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-12 text-monospace small text-muted">
                                <i class="fas fa-share-alt ml-1 mr-1" style="cursor:help" data-toggle="tooltip" data-placement="top" title="{{__('lien à partager avec les élèves')}}"></i> <a href="/p/{{ strtoupper($puzzle->jeton) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{__('ouvrir ce puzzle dans un nouvel onglet pour le tester')}}">https://www.txtpuzzle.net/p/{{ strtoupper($puzzle->jeton) }}</a>
                            </div>
                        </div>

                        <div class="collapse" id="collapse-{{$loop->iteration}}">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="text-monospace text-muted mb-3 small">
                                        <i class="fas fa-share-alt ml-1 mr-1"></i> {{__('Code à insérer dans un site web')}}
                                        <div class="mt-1" style="margin-left:22px;">
                                            <input class="form-control form-control-sm" type="text" value='<iframe src="https://www.txtpuzzle.net/iframe/{{ strtoupper($puzzle->jeton) }}" width="100%" height="600" frameborder="0"></iframe>' disabled readonly />
                                        </div>
                                        <p class="text-monospace mt-1" style="margin-left:22px;font-size:90%";color:silver>{{__('Remarque : ajuster la valeur de "height" en fonction de la taille du puzzle')}}</p>
                                    </div>
                                    <div class="text-monospace text-muted mb-4 small">
                                        <i class="fas fa-share-alt ml-1 mr-1"></i> QR code : <img src="https://api.qrserver.com/v1/create-qr-code/?data={{urlencode('www.txtpuzzle.net/p/' . $puzzle->jeton)}}&amp;size=100x100" style="width:100px" alt="wwww.txtpuzzle.net/p/{{$puzzle->jeton}}" data-toggle="tooltip" data-placement="right" title="{{__('clic droit + Enregistrer l image sous... pour sauvegarder l image')}}" />
                                    </div>
                                    @if ($puzzle->titre_eleve !== NULL OR $puzzle->consignes_eleve !== NULL)
                                        <div class="card card-body">
                                            @if ($puzzle->titre_eleve !== NULL)
                                                <div class="text-monospace small mb-1">{{ $puzzle->titre_eleve }}</div>
                                            @endif
                                            @if ($puzzle->consignes_eleve !== NULL)
                                                <div class="text-monospace text-muted small consignes">
                                                    <?php
                                                    $Parsedown = new Parsedown();
                                                    echo $Parsedown->text($puzzle->consignes_eleve);
                                                    ?>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <br />
                                    <div>{!! nl2br($puzzle->puzzle) !!}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
	</div><!-- /container -->

	@include('inc-bottom-js')

</body>
</html>
