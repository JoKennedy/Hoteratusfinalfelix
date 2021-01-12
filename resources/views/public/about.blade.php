@extends('layouts.homeLayout')
@section('content')

<section id="about">
    <div class="container">
        <div class="row about-container">
            <div class="col-lg-6 content order-lg-1 order-2 wow fadeInUp">
                <h4 class="title"><a href="">About Us</a></h4>
                <p>
                    Hoteratus Hospitality Software Solutions is a product of extensive research and more than 25 years
                    of experience in the hotel industry and online marketing and distribution, incorporating the
                    features that the properties need and asked for, customizing the user experience according to their
                    needs in this ever changing market. We continue to look for new solutions to the hotelier’s every
                    day software issues trying to ease the heavy burden of managing a property in this competitive
                    environment.
                </p>
                <p>
                    Hoteratus – Hospitality Software is a cloud based platform that allows the hoteliers to take
                    complete control of their operation from front of the house to back of the house with an extensive
                    and updated channel manager that allows them to stay connected at all times. From Guest service
                    experience to cost controls, availability and rate management including a comprehensive rate
                    management system, Hoteratus allows the hoteliers to monitor their operational performance by
                    teaming up with the best online sales partners to maximize their revenue potential. Hoteratus is the
                    perfect tool to broaden the global and local outreach of any property in this dynamic business
                    world.
                </p>
                <p>
                    Having to manage overbookings it’s a thing of the past. As availability is adjusted automatically,
                    the reservations team don’t need to do anything. The channel management function developed by
                    Hoteratus will keep the availability updated in all the channels. With a simple to use dashboard,
                    all the information you need is in one place, in an easy to read format. Our software system is
                    accessible from any devise with responsive technology for a better user experience. Whether users
                    are at the property or travelling for business, they are always in control of what happens on the
                    property, with different user levels and accessible via any mobile device.
                </p>

            </div>

            <div class="col-lg-6 background order-lg-2 order-1 wow fadeInUp"
                style="visibility: visible; animation-name: fadeInUp;">
                <img src="{{asset('vendors/img/about-img.svg')}}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>

<section id="services" class="section-bg">
    <div class="container">

        <div class="row">

            <div class="col-md-6 col-lg-5 offset-lg-1 wow bounceInLeft" data-wow-duration="1.4s">
                <div class="box">
                    <div class="icon"><i class="ion-ios-lightbulb-outline" style="color: #e9bf06;"></i></div>
                    <h4 class="title"><a href="javascript:void(0);">Mission</a></h4>
                    <p class="description text-justify">
                        Hoteratus - Hospitality Software Solutions is an avant-garde, creative software company founded
                        by hoteliers and managed by hoteliers offering high-quality, stated of the art, user-friendly
                        and <b>moderately priced,</b> one stop solution software to hoteliers. We view ourselves as
                        partners,
                        as part of the solution, and will work with fellow hoteliers, assisting them in increasing their
                        hotels’ visibility in the online market platform by providing tools to achieve the maximum
                        possible revenue, across all channels.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 wow bounceInRight" data-wow-duration="1.4s">
                <div class="box">
                    <div class="icon"><i class="ion-ios-eye-outline" style="color: #08ff00;"></i></div>
                    <h4 class="title"><a href="javascript:void(0);">Vision</a></h4>
                    <p class="description text-justify">
                        We aim to become an internationally recognized hospitality Software Company, offering the latest
                        tools for hotel management and sales distribution by decreasing the time and the cost of
                        managing the properties from A to Z and increasing the profit! We work very hard to provide the
                        hoteliers with the easiest way to manage their services by understanding their unique needs and
                        concerns and customizing their experience at all levels!
                    </p>
                </div>
            </div>

        </div>

    </div>
</section><!-- #services -->
@endsection