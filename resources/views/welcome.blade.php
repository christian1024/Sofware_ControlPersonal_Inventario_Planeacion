@extends('layouts.app')
@section('content')

    <div class="body">
        <form method="" action="./" id="form1">
            <div class="nav">
                <div class="w-row z-nav-row">
                    <div class="w-row z-nav-row">
                        <div class="w-col w-col-12" style="background-color: white">
                            <div class="col-no-margin" style="margin-top: -10px; width: 100% ; height: 98px">
                                <img src="Principal/img/Degradado.png">
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="w-row z-nav-row">
                            <div class="w-col w-col-11">
                                <div class="col-no-margin">
                                    <a href="/" class="w-inline-block link-home w--current">
                                        <img src="Principal/img/header.png" class="">

                                    </a>

                                </div>
                            </div>

                            <div class="w-col w-col-1">
                                {{--<div class="w-clearfix col-no-margin" style="float: right; position: absolute; z-index: 10">
                                    <a href="{{ route('login') }}" class="">
                                        <div href="{{ route('login') }}" class="btn btn-light" style="margin-top: 25px">Login</div>
                                    </a>

                                </div>--}}

                                <div class="btn-group " role="group">
                                    <a class="btn btn-outline-primary" style="margin-top: 25px" aria-haspopup="true" aria-expanded="false" href="{{ route('login') }}">Login</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>


    <!-- Modal -->
    {{--  <div class="modal fade" id="exampleModalCenter">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <iframe width="1020" height="480" src="{{asset('Videos/INDUCCION.mp4') }}"></iframe>
              </div>
          </div>
      </div>

      <div class="modal fade" id="lab">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <iframe width="1020" height="480" src="{{asset('Videos/LABORATORIO.mp4') }}"></iframe>
              </div>
          </div>
      </div>--}}

    <div class="w-section home-slider" style="margin-top: 98px">
        <div data-animation="cross" data-duration="500" data-infinite="1" data-nav-spacing="6" data-hide-arrows="1" data-delay="4500" data-autoplay="1" class="w-slider slider">
            <div class="w-slider-mask slider-mask">
                <div class="w-slide s1" style="transform: translateX(-4904px); opacity: 1; z-index: 135; visibility: hidden;">
                    <div class="slider-txt-block">
                        <div class="main-intro">Darwin Colombia<sup>™</sup></div>
                        {{-- <div class="slider-heading">Equipo Administrativos</div>--}}

                    </div>
                </div>
                <div class="w-slide s2" style="transform: translateX(-4904px); opacity: 1; z-index: 136; visibility: hidden;">
                    <div class="slider-txt-block">
                        <div class="main-intro">Buddleia</div>
                        <div class="slider-heading">Queen Of Hearts</div>

                    </div>
                </div>
                <div class="w-slide s3" style="transform: translateX(-4904px); opacity: 1; z-index: 137; transition: opacity 500ms ease 0s;">
                    <div class="slider-txt-block">
                        <div class="main-intro">Delosperma</div>
                        <div class="slider-heading">Jewel Of Desert</div>

                    </div>
                </div>
                <div class="w-slide s4" style="transform: translateX(-4904px); opacity: 1; z-index: 138; visibility: hidden;">
                    <div class="slider-txt-block">
                        <div class="main-intro">Armeria</div>
                        <div class="slider-heading">Dream Weaver</div>

                    </div>
                </div>
                <div class="w-slide s5" style="transform: translateX(-4904px); opacity: 1; z-index: 139; visibility: hidden;">
                    <div class="slider-txt-block">
                        <div class="main-intro">Salud</div>
                        <div class="slider-heading">Salud <sup>TM</sup> Embers</div>

                    </div>
                </div>
            </div>
            <div class="w-slider-arrow-left" style="display: block;">
                <div class="w-icon-slider-left slider-arrow-left"></div>
            </div>
            <div class="w-slider-arrow-right" style="display: block;">
                <div class="w-icon-slider-right slider-arrow-right"></div>
            </div>
            <div class="w-slider-nav">
                <div class="w-slider-dot" data-wf-ignore="" style="margin-left: 6px; margin-right: 6px;"></div>
                <div class="w-slider-dot" data-wf-ignore="" style="margin-left: 6px; margin-right: 6px;"></div>
                <div class="w-slider-dot w-active" data-wf-ignore="" style="margin-left: 6px; margin-right: 6px;"></div>
                <div class="w-slider-dot" data-wf-ignore="" style="margin-left: 6px; margin-right: 6px;"></div>
                <div class="w-slider-dot" data-wf-ignore="" style="margin-left: 6px; margin-right: 6px;"></div>
            </div>
        </div>
    </div>
    <div class="w-section main-home">
        <div class="w-container">
            <div class="home-block">
                <div class="w-row main-row">
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col1">
                        <div class="main-text-block">
                            <div class="main-text-pos">
                                <div class="main-heading">PRODUCTOS</div>
                                <div class="main-subhead">Cerca de 800 variedades en demanda desarraigadas para satisfacer su creciente mercado perenne.</div>
                                <a class="w-button main-button">Aprende más</a>
                            </div>
                        </div>
                    </div>
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col2">
                        <div data-ix="fade" class="effect-wrap">
                            <a href="https://www.darwinperennials.com/Products" class="w-inline-block main-photo-link">
                                <div class="main-photo-img-base products"></div>
                                <div class="main-photo-img products"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-block">
                <div class="w-row main-row">
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col1">
                        <div data-ix="fade" class="effect-wrap">
                            <a href="" class="w-inline-block main-photo-link">
                                <div class="main-photo-img-base selling"></div>
                                <div class="main-photo-img selling"></div>
                            </a>
                        </div>
                    </div>
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col2">
                        <div class="main-text-block">
                            <div class="main-text-pos">
                                <div class="main-heading">HERRAMIENTAS DE VENTA</div>
                                <div class="main-subhead">Explore nuestros últimos catálogos, mire un video o descargue carteles de venta y hojas de venta.</div>
                                <a href="" class="w-button main-button">Aprende más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-block">
                <div class="w-row main-row">
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col1">
                        <div class="main-text-block">
                            <div class="main-text-pos">
                                <div class="main-heading">CULTURA</div>
                                <div class="main-subhead">Encuentre las pautas de producción y acabado aquí y envíe plantas de alta calidad al mercado.</div>
                                <a href="" class="w-button main-button">Aprende más</a>
                            </div>
                        </div>
                    </div>
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col2">
                        <div data-ix="fade" class="effect-wrap">
                            <a href="" class="w-inline-block main-photo-link">
                                <div class="main-photo-img-base culture"></div>
                                <div class="main-photo-img culture"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-block">
                <div class="w-row main-row">
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col1">
                        <div data-ix="fade" class="effect-wrap">
                            <a href="" class="w-inline-block main-photo-link">
                                <div class="main-photo-img-base new"></div>
                                <div class="main-photo-img new"></div>
                            </a>
                        </div>
                    </div>
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col2">
                        <div class="main-text-block">
                            <div class="main-text-pos">
                                <div class="main-heading">NUEVAS VARIEDADES</div>
                                <div class="main-subhead">Vea las novedades de Darwin Colombia.</div>
                                <a href="" class="w-button main-button">Verlos todos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="home-block">
                <div class="w-row main-row">
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col2">
                        <div class="main-text-block">
                            <div class="main-text-pos">
                                <div class="main-heading">SOBRE NOSOTROS</div>
                                <div class="main-subhead">Conozca la finca Darwin Colombia y nuestra dedicación a la calidad insuperable del producto.</div>
                                <a href="" class="w-button main-button">Aprende más</a>
                            </div>
                        </div>
                    </div>
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col1">
                        <div data-ix="fade" class="effect-wrap">
                            <a href="" class="w-inline-block main-photo-link">
                                <div class="main-photo-img-base about"></div>
                                <div class="main-photo-img about"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-block">
                <div class="w-row main-row">
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col2">
                        <div data-ix="fade" class="effect-wrap">
                            <a href="" class="w-inline-block main-photo-link">
                                <div class="main-photo-img-base ask"></div>
                                <div class="main-photo-img ask"></div>
                            </a>
                        </div>
                    </div>
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col1">
                        <div class="main-text-block">
                            <div class="main-text-pos">
                                <div class="main-heading">PREGUNTE AL EXPERTO</div>
                                <div class="main-subhead">Los profesionales amantes de las plantas de Darwin están aquí para ayudarlo a crecer y vender con éxito.</div>
                                <a href="" class="w-button main-button">Aprende más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-block">
                <div class="w-row main-row">
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col2">
                        <div class="main-text-block">
                            <div class="main-text-pos">
                                <div class="main-heading">DONDE COMPRAR</div>
                                <div class="main-subhead">
                                    Póngase en contacto con nuestros socios distribuidores para conocer la disponibilidad del producto y satisfacer fácilmente sus necesidades perennes.
                                </div>
                                <a href="" class="w-button main-button">Aprende más</a>
                            </div>
                        </div>
                    </div>
                    <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6 home-col1">
                        <div data-ix="fade" class="effect-wrap">
                            <a href="" class="w-inline-block main-photo-link">
                                <div class="main-photo-img-base buy"></div>
                                <div class="main-photo-img buy"></div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="w-section footer orange" style="background-color: orange">
            <div class="w-container">
                <div class="w-row">
                    <div class="w-col w-col-3">
                        <div class="footer-block">
                            <a class="footer-text" href="">SISTEMAS INFORMACION</a>
                            <a class="footer-text" href="http://127.0.0.1:8000/login" target="_blank">- Darwin</a>
                            <a class="footer-text" href="Http://192.168.1.25/Nucleo" target="_blank">- Nucleo</a>
                            <a class="footer-text" href="" target="_blank">- Farmat</a>
                        </div>
                    </div>
                    <div class="w-col w-col-2 col-no-margin">

                        <div class="footer-block-social">

                            <div class="w-clearfix social-link-container">
                                <a class="w-inline-block social-link youtube" href="https://www.youtube.com/darwinperennials" target="_blank">
                                    <div>YouTube</div>
                                </a>
                            </div>

                            <div class="w-clearfix social-link-container">
                                <a class="w-inline-block social-link instagram" href="https://www.instagram.com/darwinperennials/" target="_blank">
                                    <div>Instagram</div>
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="w-col w-col-7 col-no-margin">
                        <div class="footer-point-block">
                            <div class="footer-copyright">© 2018 Ball Horticultural Company - All rights reserved</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    </form>
    </div>

@endsection


