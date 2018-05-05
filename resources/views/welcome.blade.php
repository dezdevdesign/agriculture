<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="images/logo.png" sizes="16x16">
    <title>Department of Agriculture</title>
    <meta charset="utf-8">
    <!-- Main CSS --> 
    <link rel="stylesheet" href="css/front.css">
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
    <body>
        <!-- Main navigation -->
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-primary">
            <div class="container">
                
                <!-- Company name shown on mobile -->

                <a class="navbar-brand" href="#"> <img src="images/logo.png" style="width:50px;height:50px;"> Department of Agriculture</a>

                <!-- Mobile menu toggle -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Main navigation items -->
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav mr-auto justify-content-end">
                        <li class="nav-item active">
                                <a class="nav-link" href="index.html">Home<span class="sr-only">(current)</span></a>
                        </li>

                        <!-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Examples &amp; Pages</a>
                                    <div class="dropdown-menu navbar-dark bg-primary">
                                          <a class="dropdown-item" href="examples.html">Style Examples</a>
                                          <a class="dropdown-item" href="three-column.html">Three Column</a>
                                          <a class="dropdown-item" href="one-column.html">One column / no sidebar</a>
                                          <a class="dropdown-item"  href="text.html">Text / left sidebar</a>
                                    </div>
                        </li>
 -->

                        <li class="nav-item">
                                <a class="nav-link" href="#">Services</a>
                        </li>

                        <li class="nav-item">
                                <a class="nav-link" href="#">Products</a>
                        </li>

                        <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                    
                </div>
                
                
                
            </div>
        </nav>
        
       

        <!-- Jumbtron / Slider -->
        <div class="jumbotron-wrap jumbotron-wrap-image mb-0">
            <div class="container">
                <div id="mainCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="jumbotron">
                                <h1 class="text-center"> A National Color-Coded Agricultural Guide </h1>
                                <p class="lead text-center">The Adaptation and Mitigation Initiative in Agriculture or AMIA supported the development of new planning tools.</p>
                                <p class="lead text-center">
                                    <a class="btn btn-primary btn-lg" href="#" role="button"><i class="fa fa-info"></i> &nbsp; Learn more</a>
                                </p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="jumbotron">
                                <h1 class="text-center">A Food Consumption Quantification Study</h1>
                                <p class="lead text-center">A nationwide survey will be conducted to determine the most consumed and in-demand foodstuff</p>
                                <p class="lead text-center">
                                    <a class="btn btn-primary btn-lg" href="#" role="button"><i class="fa fa-info"></i> &nbsp; Learn more</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <a class="carousel-control-prev" href="#mainCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#mainCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content area -->
        <div class="card-container">
            <div class="container">
   
                <div class="text-center padded-box pb-0">
                        <h2>Department of Agriculture</h2>
                        <p class="lead">Ang Kagawaran ng Pagsasaka (Ingles: Department of Agriculture o DA) ay ang departamentong tagapagpatupad ng Pamahalaan ng Pilipinas na responsable sa pagpapayabong ng kita ng mga magsasaka ganun na din ang pagpapababa ng insedente ng kahirapan sa mga sektor na rural ayon na rin sa nakasaad sa Katamtamang Terminong Plano ng Pamahalaan ng Pilipinas.</p>

                </div>
                


                <div class="padded-box row">
                    <div class="col-md-4">
                        <div class="card text-center">
                          <img class="card-img-top" src="images/pic1.jpg" alt="Card image cap">
                          <div class="card-body">
                            <p class="card-text"> An easy access financing program for farmers, fishermen and agriculture and fisheries stakeholders</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                          </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center">
                          <img class="card-img-top" src="images/pic2.jpg" alt="Card image cap">
                          <div class="card-body">
                            <p class="card-text">An intensive technology updating and sharing, modernization and mechanization program</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                          </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center">
                          <img class="card-img-top" src="images/pic3.jpg" alt="Card image cap">
                          <div class="card-body">
                            <p class="card-text"> A strategic and effective post-harvest, storage and processing facility</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <!-- Coloured bg jumbotron -->  
        <div class="colored-bg-container jumbotron-wrap">
            <div class="container">
                <div class="jumbotron jumbotron-narrow px-0">
                     <h2>BIYAHENG BUKID</h2>
                    <p class="lead">In response to the needs of the farmers and fishers badly affected by typhoon Vinta at the tail end of the year 2017, the Department of Agriculture awarded to the province of Lanao del Norte P7.099-million (M) worth of rice, corn and vegetable seeds, on January 4, 2018 in the municipality of Lala.</p>
                </div>
            </div>
        </div>
        
        
        
        
        <main class="container">
            <div class="row">
                
                <!-- Main content -->
                <div class="col-md-8">
                    <article>
                        <h2 class="article-title">Philippine Rural Development Project</h2>

                        <p class="article-meta">Posted on <time datetime="2017-05-14">14 May</time> by <a href="#" rel="author">Joe Bloggs</a></p>

                        <p>WeThe Philippine Rural Development Project is a six-year (6) project designed to establish the government platform for a modern, climate-smart and market-oriented agri-fishery sector. PRDP will partner with the LGUs and the private sector in providing key infrastructure, facilities, technology, and information that will raise incomes, productivity, and competitiveness in the countryside. </p>	

                        <p>Development Objectives
Within the six-year (6) project intervention, it is expected to provide the following outcomes:</p>

                        <ul>
                            <li>At least five percent (5%) increase in annual real farm incomes of PRDP in household beneficiaries</li>
                            <li>30% increase in income for targeted beneficiaries of enterprise development</li>
                            <li>Seven percent (7%) increase in value of annual marketed output</li>
                            <li>Twenty percent (20%) increase in number of farmers and fishers with improved access to DA services</li>
                        </ul>

                        <a href="#" class="btn btn-primary">Read more</a>
                        <a href="#" class="btn btn-secondary">Comments</a>

                    </article>

                    <article>

                        <h2 class="article-title">Special Area for Agricultural Development</h2>
                        <p class="article-meta">Posted on <time datetime="2013-05-14">14 May</time> by <a href="#" rel="author">Joe Bloggs</a></p>

                        <p>SAAD is a strategy of the Department of Agriculture to look at the weaknesses of an area in terms of potentials for food production and livelihood programs. It supports President Rodrigo Duterte’s thrust to increase food production and alleviate poverty. </p>

                        <p>It intends to alleviate poverty through increased food production and productivity in the target areas by providing the appropriate technology, financing, marketing and other support services in order to make the famers and fisherfolk productive and profitable. The Project is targeting individuals, families and organized farmers and fisherfolk, in the target areas. It shall prioritize those who are members of people’s organizations (POs), beneficiaries of DSWDs 4Ps and/or indigenous peoples (IPs).</p>

                        <a href="#" class="btn btn-primary">Read more</a>
                        <a href="#" class="btn btn-secondary">Comments</a>
                    </article>


                    <!-- Example pagination Bootstrap component -->
                    <nav>
                        <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                </div>

                
                <!-- Sidebar -->
                <aside class="col-md-4">
                    <div class="sidebar-box">
                        <h4>Categories</h4>
                        <div class="list-group list-group-root">
                            <a class="list-group-item active" href="index.html">Home Page</a>
                            <a class="list-group-item" href="examples.html">National Color Coded Maps</a>
                            <a class="list-group-item" href="three-column.html">Price Watch</a>
                            <a class="list-group-item" href="#">Sanitary and phytosanitary and Related issues</a>
                            <a class="list-group-item" href="#">Agricultural Creidit and Financing aids</a>
                        </div>
                    </div>

                    <div class="sidebar-box sidebar-box-bg">
                        <h4>History</h4>
                        <p>Eleven days after the proclamation of the Philippine Independence on June 12, 1898, President Emilio Aguinaldo formed his government with the Department of Agriculture and Manufacturing as one of the first agencies ...</p>    
                    </div>

                    <div class="sidebar-box">
                        <h4>Search site</h4>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="text"  placeholder="Search" aria-label="Search">
                            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </aside> 
                
                
            </div> 
        </main>
        
        
        
        <!-- Gray bg jumbotron -->
        <div class="gray-bg-container mb-0 jumbotron-wrap">
            <div class="container">
                <div class="jumbotron jumbotron-narrow px-0">
                     <h2>Secretary of Department of Agriculture</h2>
                    <p class="lead">Emmanuel “Manny” Piñol belongs to a family of farmers whose grandparents migrated to Mindanao from Iloilo shortly after the World War II and settled in M’lang, North Cotabato. In 2014, he started engaging Duterte in a series of in depth discussions on the status of Philippine Agriculture, the problems besetting it and ways of improving food production.</p>
                </div>
            </div>
        </div>

        
        
        <!-- Footer -->
        <footer class="footer">
            <div class="footer-lists">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <ul>
                                <li><h4>BUREAUS</h4></li>
                                <li><a href="#">Agricultural Training Institute</a></li>
                                <li><a href="#">Bureau of Agriculture and Fisheries Standards</a></li>
                                <li><a href="#">Bureau of Animal Industry</a></li>
                                <li><a href="#">Bureau of Agricultural Research</a></li>
                                <li><a href="#">Bureau of Fisheries and Aquatic Resources</a></li>
                            </ul>
                        </div>
                        <div class="col-sm">
                            <ul>
                                <li><h4>ATTACHED AGENCIES</h4></li>
                                <li><a href="#">Agricultural Credit Policy Council</a></li>
                                <li><a href="#">Philippine Fiber Industry Development Authority</a></li>
                                <li><a href="#">Philippine Council for Agriculture and Fisheries</a></li>
                            </ul>
                        </div>   

                        <div class="col-sm">
                            <ul>
                                <li><h4>ATTACHED CORPORATIONS </h4></li>
                                <li><a href="#">National Dairy Authority</a></li>
                                <li><a href="#">National Tobacco Administration</a></li>
                                <li><a href="#">Quedan and Rural Credit Guarantee Corporation</a></li>
                                <li><a href="#">Sugar Regulatory Administration</a></li>
                                <li><a href="#">Philippine Fisheries Development Authority</a></li>
                            </ul>
                        </div>
                        <div class="col-sm">
                            <h4>FUNCTIONS</h4>
                            <p>The Department of Agriculture is responsible for the promotion of agricultural development by providing the policy framework, public investments, and support services needed for domestic and export-oriented business enterprises. It is the primary concern of the Department to improve farm income and generate work opportunities for farmers, fishermen and other rural workers. </p>

                            <p class="social-icons">
                                <a href="#"><i class="fa fa-facebook fa-2x"></i></a>
                                <a href="#"><i class="fa fa-twitter fa-2x"></i></a>
                                <a href="#"><i class="fa fa-youtube fa-2x"></i></a>
                                <a href="#"><i class="fa fa-instagram fa-2x"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
    <div id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="padding: 10px 10px 10px 10px;">
                <div class="text-center">
                        <img src="./images/logo.png" alt="Image" class="block-center img-rounded" style="width: 50px">
                </div>
                <p class="text-center pv">LOGIN</p>
                <form role="form" data-parsley-validate="" novalidate="" method="POST" action="{{ route('login') }}" class="mb-lg">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                        <input id="username" name="username" type="text" placeholder="Enter Username" required class="form-control">
                        @if($errors->has('username'))
                            <small class="text-danger">{{ $errors->first('username') }}</small>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" name="password" type="password" placeholder="Enter Password" required class="form-control">
                        @if($errors->has('password'))
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        @endif
                    </div>
                    {{-- <div class="g-recaptcha" data-sitekey="6Lc9BEAUAAAAAI_FVULuRxskxniZAVEnCWa-7LMm"></div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif    --}}         
                    <button type="submit" class="btn btn-block btn-default mt-lg">Login</button>
                </form>
            </div>
        </div>
    </div>
</html>