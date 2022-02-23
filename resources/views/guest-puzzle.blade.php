<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @php
        $description = 'Puzzle Console - ' . strtoupper($jeton);
        $description_og = '| Puzzle Console - ' . strtoupper($jeton);
    @endphp
    @include('inc-meta')
    <title>{{ config('app.name') }} | Puzzle Console - {{strtoupper($jeton)}}</title>
</head>
<body>

    @include('inc-nav')

    <?php
    $puzzle = App\Models\Guest_puzzle::where('jeton', $jeton)->first();
    $lang = ($puzzle->lang == 'fr') ? '/':'/en';
    ?>

	<div class="container mt-5 mb-5">

        <div class="text-monospace font-weight-bolder text-center" style="font-size:1.5em;color:silver">
            <a href="/p/{{ strtoupper($puzzle->jeton) }}" target="_blank">www.txtpuzzle.net/p/{{ strtoupper($puzzle->jeton) }}</a>
        </div>
        <div class="text-center mt-2 mb-4">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{urlencode('www.txtpuzzle.net/p/' . $puzzle->jeton)}}&amp;size=100x100" style="width:100px" alt="www.txtpuzzle.net/p/{{$puzzle->jeton}}" data-toggle="tooltip" data-placement="right" title="{{__('clic droit + Enregistrer l image sous... pour sauvegarder l image')}}" />
        </div>

		<div class="row pt-3">

			<div class="col-md-2">

                <a class="btn btn-light btn-sm mb-4" href="{{$lang}}" role="button"><i class="fas fa-arrow-left"></i></a>

                <a class="btn btn-success btn-sm mb-4" href="{{route('guest-puzzle-creer-get')}}" role="button" style="width:100%;">{{__('créer un nouveau puzzle')}}</a>

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

                <div id="frame" class="frame">

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="text-monospace text-muted mb-3 small">
                                <i class="fas fa-share-alt ml-1 mr-1"></i> {{__('Code à insérer dans un site web')}}
                                <div class="mt-1" style="margin-left:22px;">
                                    <input class="form-control form-control-sm" type="text" value='<iframe src="https://www.txtpuzzle.net/iframe/{{ strtoupper($puzzle->jeton) }}" width="100%" height="600" frameborder="0"></iframe>' disabled readonly />
                                </div>
                                <p class="text-monospace mt-1" style="margin-left:22px;font-size:90%";color:silver>{{__('Remarque : ajuster la valeur de "height" en fonction de la taille du puzzle')}}</p>
                            </div>

                            @if ($puzzle->titre !== NULL)
                            <div class="row">
                                <div class="col-md-12 text-monospace text-muted">
                                    <h2 class="p-0 mt-4">{{ $puzzle->titre }}</h2>
                                </div>
                            </div>
                            @endif

                            @if ($puzzle->consignes !== NULL)
                                <div class="card card-body">
                                    <div class="text-monospace text-muted small consignes">
                                        <?php
                                        $Parsedown = new Parsedown();
                                        echo $Parsedown->text($puzzle->consignes);
                                        ?>
                                    </div>
                                </div>
                            @endif
                            <br />
                            <div>{!! nl2br($puzzle->puzzle) !!}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
	</div><!-- /container -->

	@include('inc-bottom-js')

</body>
</html>
