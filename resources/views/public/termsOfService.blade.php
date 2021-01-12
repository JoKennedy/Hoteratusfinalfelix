@extends("layouts.homeLayout")
<style>
    #header{
        position: relative !important;
    }
    #intro{
        display: none !important;
    }
    h4{
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
                <a href="#description_of_hoteratus_software" class="list-group-item">Description of Hoteratus
                    Software</a>
                <a href="#identity_authentication" class="list-group-item">Identity Authentication</a>
                <a href="#site_security" class="list-group-item">Site Security</a>
                <a href="#pci_compliance" class="list-group-item">PCI Compliance</a>
                <a href="#site_content" class="list-group-item">Site Content</a>
                <a href="#scheduled_system_interruption" class="list-group-item">SCHEDULED SYSTEM INTERRUPTION</a>
                <a href="#fees" class="list-group-item">FEES</a>
                <a href="#information_intelectualPR" class="list-group-item">INFORMATION AND INTELLECTUAL PROPERTY
                    RIGHTS</a>
                <a href="#disclaimer_of_warranties" class="list-group-item">DISCLAIMER OF WARRANTIES</a>
                <a href="#limitation_of_liability" class="list-group-item">LIMITATION OF LIABILITY</a>
                <a href="#AEAR" class="list-group-item">ASSIGNMENT; ENTIRE AGREEMENT; REVISIONS</a>
                <a href="#severability" class="list-group-item">SEVERABILITY</a>
                <a href="#indemnities_and_releases" class="list-group-item">INDEMNITIES AND RELEASES</a>
                <a href="#cancellation_and_termination" class="list-group-item">CANCELLATION AND TERMINATION</a>
                <a href="#survival" class="list-group-item">SURVIVAL</a>
                <a href="#governing_law" class="list-group-item">GOVERNING LAW</a>
                <a href="#what_information_dow_we_conllect" class="list-group-item">WHAT INFORMATION DO WE COLLECT?</a>
                <a href="#personal_infomation_you_choose_provide" class="list-group-item">1. PERSONAL INFORMATION YOU
                    CHOOSE TO PROVIDE</a>
                <a href="#website_use_information" class="list-group-item">2. WEBSITE USE INFORMATION</a>
                <a href="#storage_of_collected_information" class="list-group-item">STORAGE OF COLLECTED INFORMATION</a>
                <a href="#access_collected_information" class="list-group-item">ACCESS TO COLLECTED INFORMATION</a>
                <a href="#how_do_we_use_information" class="list-group-item">HOW DO WE USE THE INFORMATION THAT YOU
                    PROVIDE TO US?</a>
                <a href="#what_are_cookies" class="list-group-item">WHAT ARE COOKIES?</a>
                <a href="#how_do_we_use_information_collect_from_cookies" class="list-group-item">HOW DO WE USE
                    INFORMATION WE COLLECT FROM COOKIES?</a>
                <a href="#ip_address" class="list-group-item">IP ADDRESS</a>
                <a href="#Sharing_selling_information" class="list-group-item">SHARING AND SELLING INFORMATION</a>
            </div>
        </div>
        <div class="col-md-9">
            <h2 class="text-center font-weight-bold">Terms and Conditions</h2>
            <div class="" id="grant_of_licence">
                <h4>GRANT OF LICENCE</h4>
                <p><b>Hoteratus – Hospitality Software Solutions</b> (‘We’ , ‘Our’) provides hospitality Software and
                    related
                    services
                    ('Hoteratus Software') to you subject to the following Terms and Conditions.</p>
                <p>By accepting these Terms, or by accessing or using the Hoteratus Software, You represent and
                    acknowledge that
                    You
                    have read, understood, and agree to be bound by these Terms, and that the information You provide in
                    registering
                    with the Hoteratus Software is accurate, complete, and is Yours or within Your right to use. If You
                    are
                    entering
                    into these Terms on behalf of a company or another legal entity, You represent that You have the
                    authority
                    to
                    bind such entity and its affiliates to these Terms, in which case the terms 'You' , 'Your' or
                    related
                    capitalized terms herein shall refer to such entity and its affiliates. If You do not have such
                    authority,
                    or if
                    You do not agree with these Terms, You must not accept these Terms and may not use the Hoteratus
                    Software.
                </p>
                <p>You acknowledge that these Terms constitute a contract between You and Hoteratus, even though it is
                    electronic
                    and is not physically signed by You and Hoteratus, and that these Terms govern Your use of the
                    Hoteratus
                    Software and supersede any prior agreements between You and Hoteratus.
                </p>

                <h4 id="description_of_hoteratus_software">DESCRIPTION OF HOTERATUS SOFTWARE</h4>
                <p>
                    The Hoteratus Software includes the full package of the Hoteratus Property Management System, and
                    the
                    related support services provided to You, including all software, data, text, images, sounds,
                    videos, and
                    other content provided by Hoteratus. Any new features added to or augmenting the Hoteratus Software
                    and
                    related services are also subject to these Terms.
                </p>

                <h4 id="identity_authentication">IDENTITY AUTHENTICATION</h4>
                <p>
                    We use many techniques to identify You when You register on the Hoteratus Software. To comply with
                    legislative requirements, and global sanctions, we screen our customer accounts and may collect
                    information
                    from You to satisfy such requirements and sanctions. We may request that You provide us with
                    documentation
                    to help prove Your identity for business verification purposes. Under these terms of use, You
                    authorise
                    Hoteratus, directly or through third parties, to make any inquiries we consider necessary to
                    validate Your
                    registration.
                </p>

                <h4 id="site_security">SITE SECURITY</h4>
                <p>
                    Hoteratus shall provide You with a username and password to access the Hoteratus Software. All users
                    who
                    that access the Hoteratus Software service do so with User account(s) which are provided to them by
                    Hoteratus. You are responsible for maintaining the confidentiality of your user account information
                    and your
                    password. You agree to accept responsibility for all activities and changes to data that occur under
                    your
                    user account(s) or password(s). Hoteratus will not be held accountable for changes made by either
                    the users
                    or the Booking Channels.
                </p>

                <h4 id="pci_compliance">PCI COMPLIANCE</h4>
                <p>
                    Hoteratus agrees that it is responsible for the security of cardholder data that it possesses,
                    including the
                    functions relating to storing, processing, and transmitting of the cardholder data. Hoteratus uses
                    SSL
                    encryption to transmit all credit card data and other confidential information. Hoteratus affirms
                    that, as
                    of the last updated date of these terms and conditions, it has complied with all applicable
                    requirements to
                    be considered PCI DSS compliant, and has performed the necessary steps to validate its compliance
                    with the
                    PCI DSS.
                </p>
                <p>
                    Hoteratus affirms that we will review and validate our compliance at least annually, and will
                    perform
                    necessary vulnerability scans on our systems at least quarterly. Hoteratus will immediately notify
                    You if we
                    learn that we are no longer PCI DSS compliant and will immediately inform You of the steps being
                    taken to
                    remediate the non-compliance status. In no event should Hoteratus notification to You be later than
                    thirty
                    (30) calendar days after Hoteratus learns we are no longer PCI DSS compliant.
                </p>

                <h4 id="site_content">SITE CONTENT</h4>
                <p>
                    You are solely responsible for the accuracy and currency of the Data entered into the Hoteratus
                    Software
                    under Your user account. You agree to indemnify Hoteratus, its related companies, officers,
                    employees and
                    its suppliers against liability or loss arising from, and cost incurred in connection with any data
                    entered
                    into the Hoteratus Software under your account.
                </p>

                <h4 id="scheduled_system_interruption">SCHEDULED SYSTEM INTERRUPTION</h4>
                <p>
                    Hoteratus may make changes to the Hoteratus Software from time to time. Should changes be made to
                    any
                    component of the system that could affect Your operation of the system You will be notified at least
                    twelve
                    (12) hours in advance of such change. To apply upgrades and other changes to the System Software,
                    the
                    Hoteratus Software may be made temporarily unavailable. To minimize impact to your usage of the
                    system,
                    Hoteratus will attempt to make any outages as short as possible and at a time of day where system
                    usage is
                    at its minimum.
                </p>

                <h4 id="fees">FEES</h4>
                <p>
                    Hoteratus reserves the right to change fees with ten (10) days notice to You unless You have signed
                    a 12 or
                    24 month user agreement in which case the pricing terms of such agreement will take precedence over
                    these
                    terms and conditions.
                </p>

                <h4 id="information_intelectualPR">INFORMATION AND INTELLECTUAL PROPERTY RIGHTS</h4>
                <p>
                    You acknowledge and agree that Hoteratus owns all right, title and interests in and to the Hoteratus
                    Software (including but not limited to any images, photographs, animations, video, audio, music,
                    text, and
                    'applets', incorporated into the Hoteratus Software, the accompanying documentation and printed
                    materials,
                    and any copies of the Hoteratus Software. Hoteratus does not grant You any right, title or interest
                    in or to
                    the Hoteratus Software.
                </p>
                <p>
                    The URLs representing the Hoteratus website(s), 'Hoteratus' and all related logos of our products
                    and
                    services described in our website(s) are either subject to copyright, trademark or existing
                    registered
                    trademark ownership by Hoteratus and may not be copied, imitated or used, in whole or in part,
                    without the
                    prior written permission of Hoteratus.
                </p>

                <h4 id="disclaimer_of_warranties">DISCLAIMER OF WARRANTIES</h4>
                <p>
                    Hoteratus, its related companies, officers, employees and its suppliers provide the Hoteratus
                    Software and
                    related services 'as is' and without any warranty or condition, express, implied or statutory to the
                    maximum
                    extent permitted by law. Hoteratus, its related companies, officers, employees and its suppliers
                    specifically disclaim any implied warranties of title, merchantability, fitness for a particular
                    purpose and
                    non-infringement to the maximum extent permitted by law. We do not guarantee continuous,
                    uninterrupted
                    access to Hoteratus Software and related services, and operation of the Hoteratus Software and our
                    website(s) may be interfered with by numerous factors outside of our control.
                </p>

                <h4 id="limitation_of_liability">LIMITATION OF LIABILITY</h4>
                <p>
                    No Consequential Damages. Under no circumstances and under no legal theory (whether in contract,
                    tort,
                    negligence or otherwise) will either party to these terms, or such party's affiliates or their
                    respective
                    officers, directors, employees, agents, suppliers or licensors be liable to the other party or any
                    third
                    party for any indirect, incidental, special, exemplary, consequential, punitive or other similar
                    damages,
                    including lost profits, lost sales or business, lost data, business interruption or any other loss
                    incurred
                    by such party in connection with this agreement or the service, regardless of whether such party has
                    been
                    advised of the possibility of or could have foreseen such damages.
                </p>
                <p>
                    Force Majeure And Third Parties. You agree that Hoteratus is not liable for failure or delay in
                    performing
                    its obligations hereunder if such failure or delay is due to circumstances beyond its reasonable
                    control,
                    including, without limitation, acts of any government authority, war, sabotage, fire, flood, strike
                    or other
                    labour disturbance, interruption of or delay in transportation, unavailability of or delay in
                    telecommunications or third party services, failure of third party software or inability to obtain
                    raw
                    materials, supplies, or power used in or equipment needed for provision of Services.
                </p>
                <p>
                    Limits On Monetary Damages. Notwithstanding anything to the contrary in these terms, Hoteratus's
                    (including
                    any of its affiliates) aggregate liability, for damages (monetary or otherwise) under these terms
                    during any
                    calendar year for claims made by you or any third party arising from our service, shall be limited
                    to the
                    lesser of (i) actual damages incurred, or (ii) payments made by you for the service during the four
                    (4)
                    months preceding the claim. The parties acknowledge and agree that the essential purpose of this
                    clause is
                    to allocate the risks under these terms between the parties and limit their potential liability
                    given the
                    fees charged under this agreement, which would have been substantially higher if Hoteratus were to
                    assume
                    any further liability other than as set forth herein. The parties have relied on these limitations
                    in
                    determining whether to enter into this agreement.
                </p>

                <h4 id="AEAR">ASSIGNMENT; ENTIRE AGREEMENT; REVISIONS</h4>
                <p>
                    Either party may assign or transfer these Terms, in whole or in part, without restriction, provided
                    the
                    assignee agree to be fully bound by these Terms. These Terms supersede prior versions of these
                    Terms, or any
                    other discussions, agreements or understandings by or among the parties (other than written
                    agreements
                    accepted by both parties). We may amend these Terms from time to time, in which case the new Terms
                    will
                    supersede prior versions. We will notify You of such changes and direct You to the latest version.
                </p>

                <h4 id="severability">SEVERABILITY</h4>
                <p>If any provision in these Terms is held by a court of competent jurisdiction to be unenforceable,
                    such
                    provision shall be modified by the court and interpreted so as to best accomplish the original
                    provision to
                    the fullest extent permitted by law, and the remaining provisions of these Terms shall remain in
                    effect.</p>

                <h4 id="indemnities_and_releases">INDEMNITIES AND RELEASES</h4>
                <p>
                    You agree to indemnify and keep indemnified Hoteratus, its related companies, officers, employees
                    and its
                    suppliers against liability or loss arising from, and cost incurred in connection with, damage,
                    loss, injury
                    or death to any third party caused or contributed to by Your act, neglect or default, or the act,
                    neglect or
                    default of Your servants and agents.
                </p>
                <p>
                    Hoteratus acknowledges that, in the course of its performance of this Agreement, it may become privy
                    to
                    certain information that You deem as being proprietary and confidential. Confidential Information
                    means any
                    information of Yours that is by its nature is confidential or is designated by You as confidential.
                    Hoteratus agrees that it will use Your Confidential Information solely for the purposes of the
                    provision of
                    the Hoteratus service to You and will not disclose Your Confidential Information, directly or
                    indirectly, to
                    any third party without Your prior written consent.
                </p>

                <h4 id="cancellation_and_termination">CANCELLATION AND TERMINATION</h4>
                <p>
                    Hoteratus reserves the right to terminate Your access to the Hoteratus Software at any time for any
                    reason
                    whatsoever with ten (10) days notice to You. Hoteratus shall not be liable to You or any third party
                    for any
                    modification, suspension or discontinuation of the Service. If You breach any of the terms of this
                    agreement
                    Hoteratus reserves the right to terminate Your access to the Hoteratus Software immediately on
                    becoming
                    aware of such breach.
                </p>
                <p>You may cancel your subscription with ten (10) days notice, by emailing <a
                        href="mailto:support@hoteratus.com">support@hoteratus.com</a>
                </p>

                <h4 id="survival">SURVIVAL</h4>
                <p>
                    Intellectual Property Rights, Cancellation and Termination, Disclaimer of Warranties, Limitation of
                    Liability, Indemnities And Releases, Assignment; Entire Agreement; Revisions, Severability, and
                    Governing
                    Law will survive any termination of these Terms.
                </p>

                <h4 id="governing_law">GOVERNING LAW</h4>
                <p>
                    This Agreement shall be governed by and construed in accordance with the laws of the State of
                    Delaware and
                    the parties submit to the jurisdiction the State of Delaware courts. This Agreement is governed by
                    the State
                    of Delaware laws. Our failure to act with respect to a breach by You or others does not waive our
                    right to
                    act with respect to subsequent or similar breaches. These Terms And Conditions detail the entire
                    understanding between us concerning its subject matter.
                </p>

                <h4 id="what_information_dow_we_conllect">WHAT INFORMATION DO WE COLLECT?</h4>
                <p>
                    When you visit this website you may provide us with two types of information: personal information
                    you
                    knowingly choose to disclose that is collected on an individual basis, and website use information
                    collected
                    on an aggregate basis as you and others browse our website.
                </p>

                <h4 id="personal_infomation_you_choose_provide">1. PERSONAL INFORMATION YOU CHOOSE TO PROVIDE</h4>
                <p>
                    Registration Information. When You register for any of our services or newsletters you will provide
                    us with
                    information about yourself.
                </p>
                <p>
                    Email Information. If you choose to correspond with us through email, we may retain the content of
                    your
                    email messages together with your email address and our responses. We provide the same level of
                    protection
                    for electronic communications as we do for information received by mail and telephone.
                </p>
                <p>
                    Communication with You. Registration or correspondence with us via email constitutes a commercial
                    relationship and implies consent for us to communicate with you regarding our services. We promise
                    to only
                    send you information deemed relevant to our commercial relationship and any email communication you
                    may
                    receive from us highlighting our services, special offers or promotions will include an opt out or
                    unsubscribe feature.
                </p>

                <h4 id="website_use_information">2. WEBSITE USE INFORMATION</h4>
                <p>
                    Similar to other commercial websites, our website utilises a standard technology called 'cookies'
                    (see
                    explanation below, 'What Are Cookies?') and web server log files to collect information about how
                    our
                    website is used. Information gathered through cookies and web server logs may include the date and
                    time of
                    visits, the pages viewed, time spent at our website, and the websites visited just before and just
                    after our
                    website.
                </p>

                <h4 id="storage_of_collected_information">STORAGE OF COLLECTED INFORMATION</h4>
                <p>
                    The security of your personal information is important to us. When you enter sensitive information
                    (such as
                    credit card numbers) on our website, we encrypt that information using secure socket layer
                    technology (SSL).
                    When credit card details are collected, we simply pass them on in order to be processed as required.
                    We
                    never permanently store complete credit card details.
                </p>
                <p>
                    We follow generally accepted industry standards to protect the personal information submitted to us,
                    both
                    during transmission and once we receive it.
                </p>

                <h4 id="access_collected_information">ACCESS TO COLLECTED INFORMATION</h4>
                <p>
                    If your personally identifiable information changes, or if you no longer desire our service, you may
                    correct, update, delete or deactivate it by emailing us at <a href="mailto:accounts@hoteratus.com">accounts@hoteratus.com</a>. If you wish to
                    deactivate
                    your service, we will require ten (10) days notice in writing.
                </p>

                <h4 id="how_do_we_use_information">HOW DO WE USE THE INFORMATION THAT YOU PROVIDE TO US?</h4>
                <p>
                    Broadly speaking, we use personal information for purposes of administering our business activities,
                    provision of services, monitoring the use of services, marketing and promotional efforts, from us
                    and any
                    other third party partner that we may choose to, improvement of our content and service offerings,
                    and
                    customisation of our website's content, layout, services and other lawful purposes. These activities
                    improve
                    our site and enable us to better tailor it to meet your needs.
                </p>
                <p>
                    Furthermore, such information may be shared with others on an aggregate basis. Occasionally, we may
                    also use
                    the information we collect to notify you about important changes to our website, new services, and
                    special
                    offers from us and other third parties that we think you will find valuable. You may notify us at
                    any time
                    if you do not wish to receive these offers
                </p>

                <h4 id="what_are_cookies">WHAT ARE COOKIES?</h4>
                <p>
                    A cookie is a very small text document, which often includes an anonymous unique identifier. When
                    you visit
                    a website, that site's computer asks your computer for permission to store this file in a part of
                    your hard
                    drive specifically designated for cookies. Each website can send its own cookie to your browser if
                    your
                    browser's preferences allow it, but (to protect your privacy) your browser only permits a website to
                    access
                    the cookies it has already sent to you, not the cookies sent to you by other sites. Browsers are
                    usually set
                    to accept cookies. However, if you would prefer not to receive cookies, you may alter the
                    configuration of
                    your browser to refuse cookies. If you choose to have your browser refuse cookies, it is possible
                    that some
                    areas of our site will not function as effectively when viewed by the users. A cookie cannot
                    retrieve any
                    other data from your hard drive or pass on computer viruses.
                </p>

                <h4 id="how_do_we_use_information_collect_from_cookies">HOW DO WE USE INFORMATION WE COLLECT FROM
                    COOKIES?</h4>
                <p>
                    As you visit and browse our website, the site uses cookies to differentiate you from other users. In
                    some
                    cases, we also use cookies to prevent you from having to log in more than is necessary for security.
                    Cookies, in conjunction with our web server's log files, allow us to calculate the aggregate number
                    of
                    people visiting our website and which parts of the site are most popular. This helps us gather
                    feedback to
                    constantly improve our website and better serve our clients. Cookies do not allow us to gather any
                    personal
                    information about you and we do not intentionally store any personal information that your browser
                    provided
                    to us in your cookies.
                </p>

                <h4 id="ip_address">IP ADDRESSES</h4>
                <p>
                    IP addresses are used by your computer every time you are connected to the Internet. Your IP address
                    is a
                    number that is used by computers on the network to identify your computer. IP addresses are
                    automatically
                    collected by our web server as part of demographic and profile data known as traffic data so that
                    data (such
                    as the web pages you request) can be sent to you.
                </p>

                <h4 id="sharing_selling_information">SHARING AND SELLING INFORMATION</h4>
                <p>We may share, sell, lend or lease any of the information that uniquely identify a subscriber (such as
                    email
                    addresses or personal details).
                </p>
            </div>
        </div>
    </div>

</section>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function(){ 
    $("body").attr("data-spy","scroll");
    $("body").attr("data-target","#listTerms");
    $("body").attr("data-offset","1");
}, false);
</script>
