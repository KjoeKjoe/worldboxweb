<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content="Kjoekjoe"/>
    <title>KjoeMod</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
</head>
<body>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">KjoeMod Worldbox</h1>
            <p class="lead fw-normal text-white-50 mb-0">Stats of the Worldbox users</p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5 ">
        <div class="row">
            <div class="col m-auto">
                <div class="position-absolute" style="left: 50%;">
{{--                    <img class="position-relative mr-auto ml-auto" src="{{asset('storage/unit.png')}}"--}}
{{--                         style="left: -50%;">--}}
                </div>
                <img class="d-block m-auto" src="{{asset('storage/map.png')}}">
            </div>
        </div>
    </div>
    <div class="container px-4 px-lg-5 mt-5">
        <div id="accordion">
            <div class="card">
                <div class="card-header text-center" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link m-auto" data-toggle="collapse" data-target="#collapseOne"
                                aria-controls="collapseOne">
                            Commands
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <p>
                            We've got a couple cmd's ready!
                        </p>
                        <div class="d-block text-white bg-dark shadow-lg rounded-2">
                            <p class="font-monospace">
                                !wb-shop //See the shop! see all trait prices, skill prices and everything..
                            </p>
                            <p class="font-monospace">
                                !wb-currency //Get to see your currency/balance
                            </p>
                            <p class="font-monospace">
                                !wb-watch //Watch yourself at the big screen!
                            </p>
                            <p class="font-monospace">
                                !wb-add //Add yourself to the game
                            </p>
                            <p class="font-monospace">
                                !wb-buy-trait (Trait) ((Buy a Trait (giant, blessed, immortal)
                            </p>
                            <p class="font-monospace">
                                !wb-buy-level (Skill) //Buy a skill you want to increase (health, attack_speed,
                                diplomacy..)
                            </p>
                            <p class="font-monospace">
                                !wb-set-race (Race) //Set the race you want to play (human, elf, orc, dwarf)
                            </p>
                            <p class="font-monospace">
                                !wb-set-nickname (Nickname) //Set the nickname you want to play under
                            </p>
                            <p class="font-monospace">
                                !wb-buy-helmet (material) //buy helmet
                            </p>
                            <p class="font-monospace">
                                !wb-buy-armor (material) //buy armor
                            </p>
                            <p class="font-monospace">
                                !wb-buy-boots (material) //buy boots
                            </p>
                            <p class="font-monospace">
                                !wb-buy-amulet (material) //buy amulet
                            </p>
                            <p class="font-monospace">
                                !wb-buy-ring (material) //buy ring
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link m-auto" data-toggle="collapse" data-target="#collapseTwo"
                                aria-controls="collapseTwo">
                            Shop
                        </button>
                    </h5>
                </div>

                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <div class="d-block text-white bg-dark shadow-lg rounded-2">
                            <p class="font-monospace">
                                Levels:
                            </p>
                            @forelse(json_decode($levels) as $level => $price)
                            <p class="font-monospace">
                                  {{$level}} - {{$price}}
                            </p>
                            @empty
                            @endforelse
                            <p class="font-monospace">
                                Events:
                            </p>
                            @forelse(json_decode($events) as $name => $event)
                            <p class="font-monospace">
                                  {{$name}} - {{$event->price}}
                            </p>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @forelse($slaves as $slave)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                    {{--                        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />--}}
                    <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                @if($slave->is_twitch)
                                    <h5 class="fw-bolder">{{$slave->nickname}}</h5>
                                @else
                                    <h5 class="fw-bolder">{{explode("#", $slave->firstName)[0]}}</h5>
                                @endif
                                <p class="font-monospace">{{$slave->nickname}}</p>
                                <!-- Product price-->
                                <div class="row">
                                    <div class="col">Currency</div>
                                    <div class="col">Health</div>
                                </div>
                                <div class="row">
                                    <div class="col">{{$slave->currency}}</div>
                                    <div class="col">{{$slave->health}}</div>
                                </div>
                                <div class="row">
                                    <div class="col fw-bold">Traits</div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        @forelse(json_decode($slave->traits)->trait_data as $trait)
                                            {!! $trait !!},
                                        @empty
                                            No Traits ;-;
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <form method="post" action="{{route('watch', $slave->id)}}" class="m-auto">
                            @method('post')
                            @csrf
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <button type="submit" class="btn btn-outline-dark m-auto">Watch Person</button>
                            </div>
                        </form>
                        <div class="card-header text-center" id="heading{{$slave->id}}">
                            <h5 class="mb-0">
                                <button class="btn btn-link m-auto" data-toggle="collapse"
                                        data-target="#collapse{{$slave->id}}" aria-controls="collapse{{$slave->id}}">
                                    More Stats
                                </button>
                            </h5>
                        </div>
                        <div id="collapse{{$slave->id}}" class="collapse" aria-labelledby="heading{{$slave->id}}"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">Stat</div>
                                    <div class="col-4 text-right">value</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">age</div>
                                    <div class="col-4 text-right">{{$slave->age}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">kills</div>
                                    <div class="col-4 text-right">{{$slave->kills}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">children</div>
                                    <div class="col-4 text-right">{{$slave->children}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_health</div>
                                    <div class="col-4 text-right">{{$slave->base_health}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_diplomacy</div>
                                    <div class="col-4 text-right">{{$slave->base_diplomacy}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_warfare</div>
                                    <div class="col-4 text-right">{{$slave->base_warfare}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_stewardship</div>
                                    <div class="col-4 text-right">{{$slave->base_stewardship}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_intelligence</div>
                                    <div class="col-4 text-right">{{$slave->base_intelligence}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_attack_speed</div>
                                    <div class="col-4 text-right">{{$slave->base_attack_speed}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">attack_speed</div>
                                    <div class="col-4 text-right">{{$slave->attack_speed}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_accuracy</div>
                                    <div class="col-4 text-right">{{$slave->base_accuracy}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">accuracy</div>
                                    <div class="col-4 text-right">{{$slave->accuracy}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_speed</div>
                                    <div class="col-4 text-right">{{$slave->base_speed}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">speed</div>
                                    <div class="col-4 text-right">{{$slave->speed}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_crit</div>
                                    <div class="col-4 text-right">{{$slave->base_crit}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">crit</div>
                                    <div class="col-4 text-right">{{$slave->crit}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">base_armor</div>
                                    <div class="col-4 text-right">{{$slave->base_armor}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-8">armor</div>
                                    <div class="col-4 text-right">{{$slave->armor}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="row">
                    <div class="col">No Slaves :(</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; KjoeMod 2022</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<!-- Core theme JS-->
<script src="{{asset('js/scripts.js')}}"></script>
</body>
</html>
