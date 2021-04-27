<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/about/index.css') }}">
    <title>About Us</title>
</head>

<body>

    @include('layouts.nav')

    <main>
        <header>
            <section class="sectionHeader">
                <h1>ABOUT US</h1>
                <p>HELPING PEOPLE, IMPROVING LIVES</p>
            </section>
        </header>
        <section>
            <h3>Who We Are</h3>
            <p>
                We are an online sales performance agency. Launched in 2021, we help businesses drive revenue with the
                use of inbound marketing and sales enablement tactics with the aid of surveys regarding their sales
                through bills and receipts.
            </p>
            <p>
                Our team is made up of smart and talented people that are passionate about creating astonishing
                results in assisting businesses achieve their marketing goals.
            </p>
        </section>
        <section>
            <h3>Our Business Model</h3>
            <p>
                Our agency generates money from our business owners partners who pay us by providing marketing
                strategies and tactics that we gathered from our affiliates who provide us tangible informations in the
                form of receipts that they recieved by purchasing goods and services from similar business models.
            </p>
            <p>In return, our agency rewards our affiliates bonuses and cash prizes that they can normally acquire in
                their account wallets that can be found in our platform.
            </p>
        </section>
        <section class="bundle">
            <section>
                <h3>Our Mission</h3>
                <p>
                    Our mission is to help the business and customer partnership by helping the business owners to know
                    more about their target markets and rewarding our affiliates who participates in marketing surveys
                    that are conducted by our agency.
                </p>
            </section>
            <section>
                <h3>Our Vision</h3>
                <p>
                    Our vision is by 2025, we've already helped hundreds of small to medium scale business owners on
                    their sales revenue and helped thousands of our affiliates by rewarding their efforts and hopefully
                    change their lives.
                </p>
            </section>
        </section>
        <section>
            <h3>Contact Us</h3>
            <p>
                <span>For concerns, complains and suggestions you may contact us at:</span>
            </p>
            <p>
                <span>Email:</span> <br>
                peraagadcustomercare@gmail.com
            </p>
            <p>
                <span>Contact Nos. :</span> <br>
                0948 855 9171(Smart or TNT) <br>
                0935 751 8223(Globe or TM)
            </p>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>

</html>