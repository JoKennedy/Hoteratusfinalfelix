@extends("layouts.homeLayout")
<style>
    #header {
        position: relative !important;
    }

    #intro {
        display: none !important;
    }
    h4 {
        padding-top: 1.6rem !important;
    }
    p{
        text-align: justify;
    }
</style>
@section('content')
<section id="termsOfService" class="mt-5">
    <div class="row w-100">
        <div class="col-md-3">
            <div class="list-group list-group-flush" id="listTerms" style="position: sticky; top: 10px;">
                <div class="input-group mb-3 px-3">
                    <input type="text" id="searhTerms" class="form-control" placeholder="Searh">
                    <div class="input-group-prepend">
                        <i class="input-group-text fa fa-search"></i>
                    </div>
                </div>
                <a href="#what_information_do_we_collected" class="list-group-item">WHAT INFORMATION DO WE COLLECT?</a>
                <a href="#personal_information_choose_provide" class="list-group-item">1. PERSONAL INFORMATION YOU
                    CHOOSE TO PROVIDE</a>
                <a href="#website_use_information" class="list-group-item">2. WEBSITE USE INFORMATION</a>
                <a href="#storage_collected_information" class="list-group-item">STORAGE OF COLLECTED INFORMATION</a>
                <a href="#access_collected_information" class="list-group-item">ACCESS TO COLLECTED INFORMATION</a>
                <a href="#how_do_we_use_information_you_provide" class="list-group-item">HOW DO WE USE THE INFORMATION THAT YOU
                    PROVIDE TO US?</a>
                <a href="#what_are_cookies" class="list-group-item">WHAT ARE COOKIES?</a>
                <a href="#how_do_we_use_information_collect_from_cookies" class="list-group-item">HOW DO WE USE
                    INFORMATION WE COLLECT FROM COOKIES?</a>
                <a href="#ip_address" class="list-group-item">IP ADDRESS</a>
                <a href="#Sharing_selling_information" class="list-group-item">SHARING AND SELLING INFORMATION</a>
                <a href="#how_can_you_access_coorect_information" class="list-group-item">HOW CAN YOU ACCESS AND CORRECT YOUR INFORMATION?</a>
            </div>
        </div>
        <div class="col-md-9">
            <h2 class="text-center font-weight-bold">PRIVACY STATEMENT</h2>
            <div class="" id="grant_of_licence">
                <h4 id="what_information_do_we_collected">WHAT INFORMATION DO WE COLLECT?</h4>
                <p>
                    When you visit this website you may provide us with two types of information: personal information
                    you knowingly choose to disclose that is collected on an individual basis, and website use
                    information collected on an aggregate basis as you and others browse our website.
                </p>

                <h4 id="personal_information_choose_provide">1. PERSONAL INFORMATION YOU CHOOSE TO PROVIDE</h4>
                <p>
                    Registration Information. When You register for any of our services or newsletters you will provide
                    us with information about yourself.
                </p>
                <p>
                    Email Information. If you choose to correspond with us through email, we may retain the content of
                    your email messages together with your email address and our responses. We provide the same level of
                    protection for electronic communications as we do for information received by mail and telephone.
                </p>
                <p>
                    Communication with You. Registration or correspondence with us via email constitutes a commercial
                    relationship and implies consent for us to communicate with you regarding our services. We promise
                    to only send you information deemed relevant to our commercial relationship and any email
                    communication you may receive from us highlighting our services, special offers or promotions will
                    include an opt out or unsubscribe feature.
                </p>

                <h4 id="website_use_information">2. WEBSITE USE INFORMATION</h4>
                <p>
                    Similar to other commercial websites, our website utilises a standard technology called 'cookies'
                    (see explanation below, 'What Are Cookies?') and web server log files to collect information about
                    how our website is used. Information gathered through cookies and web server logs may include the
                    date and time of visits, the pages viewed, time spent at our website, and the websites visited just
                    before and just after our website.
                </p>

                <h4 id="storage_collected_information">STORAGE OF COLLECTED INFORMATION</h4>
                <p>
                    The security of your personal information is important to us. When you enter sensitive information
                    (such as credit card numbers) on our website, we encrypt that information using secure socket layer
                    technology (SSL). When credit card details are collected, we simply pass them on in order to be
                    processed as required. We never permanently store complete credit card details.
                </p>
                <p>
                    We follow generally accepted industry standards to protect the personal information submitted to us,
                    both during transmission and once we receive it.
                </p>

                <h4 id="access_collected_information">ACCESS TO COLLECTED INFORMATION</h4>
                <p>
                    If your personally identifiable information changes, or if you no longer desire our service, you may
                    correct, update, delete or deactivate it by emailing us at <a href="mailto:accounts@hoteratus.com">accounts@hoteratus.com</a>. If you wish to
                    deactivate your service, we will require ten (10) days notice in writing.
                </p>

                <h4 id="how_do_we_use_information_you_provide">HOW DO WE USE THE INFORMATION THAT YOU PROVIDE TO US?</h4>
                <p>
                    Broadly speaking, we use personal information for purposes of administering our business activities,
                    provision of services, monitoring the use of services, marketing and promotional efforts, from us
                    and any other third party partner that we may choose to, improvement of our content and service
                    offerings, and customisation of our website's content, layout, services and other lawful purposes.
                    These activities improve our site and enable us to better tailor it to meet your needs.
                </p>
                <p>
                    Furthermore, such information may be shared with others on an aggregate basis. Occasionally, we may
                    also use the information we collect to notify you about important changes to our website, new
                    services, and special offers from us and other third parties that we think you will find valuable.
                    You may notify us at any time if you do not wish to receive these offers.
                </p>

                <h4 id="what_are_cookies">WHAT ARE COOKIES?</h4>
                <p>
                    A cookie is a very small text document, which often includes an anonymous unique identifier. When
                    you visit a website, that site's computer asks your computer for permission to store this file in a
                    part of your hard drive specifically designated for cookies. Each website can send its own cookie to
                    your browser if your browser's preferences allow it, but (to protect your privacy) your browser only
                    permits a website to access the cookies it has already sent to you, not the cookies sent to you by
                    other sites. Browsers are usually set to accept cookies. However, if you would prefer not to receive
                    cookies, you may alter the configuration of your browser to refuse cookies. If you choose to have
                    your browser refuse cookies, it is possible that some areas of our site will not function as
                    effectively when viewed by the users. A cookie cannot retrieve any other data from your hard drive
                    or pass on computer viruses.
                </p>

                <h4 id="how_do_we_use_information_collect_from_cookies">HOW DO WE USE INFORMATION WE COLLECT FROM COOKIES?</h4>
                <p>
                    As you visit and browse our website, the site uses cookies to differentiate you from other users. In
                    some cases, we also use cookies to prevent you from having to log in more than is necessary for
                    security. Cookies, in conjunction with our web server's log files, allow us to calculate the
                    aggregate number of people visiting our website and which parts of the site are most popular. This
                    helps us gather feedback to constantly improve our website and better serve our clients. Cookies do
                    not allow us to gather any personal information about you and we do not intentionally store any
                    personal information that your browser provided to us in your cookies.
                </p>

                <h4 id="ip_address">IP ADDRESSES</h4>
                <p>
                    IP addresses are used by your computer every time you are connected to the Internet. Your IP address
                    is a number that is used by computers on the network to identify your computer. IP addresses are
                    automatically collected by our web server as part of demographic and profile data known as traffic
                    data so that data (such as the web pages you request) can be sent to you.
                </p>

                <h4 id="sharing_selling_information">SHARING AND SELLING INFORMATION</h4>
                <p>
                    We may share, sell, lend or lease any of the information that uniquely identify a subscriber (such
                    as email addresses or personal details).
                </p>

                <h4 id="how_can_you_access_coorect_information">HOW CAN YOU ACCESS AND CORRECT YOUR INFORMATION?</h4>
                <p>You may request access to all your personally identifiable information that we collect online and
                    maintain in our database by emailing us at <a href="mailto:support@hoteratus.com">support@hoteratus.com</a> 
                </p>
            </div>
        </div>
    </div>

</section>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $("body").attr("data-spy", "scroll");
        $("body").attr("data-target", "#listTerms");
        $("body").attr("data-offset", "1");
    }, false);
</script>