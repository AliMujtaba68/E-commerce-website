@extends('layouts.master')
@section('title', 'About Us')
@section('content')
    <main class="about-page">
        <section class="about-overview">
            <div class="container">
                <h1 class="section-title">About Us</h1>
                <div class="overview-content">
                    <p>Welcome to our company! We are dedicated to providing top-notch products and services that meet your needs. Our team of experts works tirelessly to ensure that you receive the best experience possible.</p>
                </div>
            </div>
        </section>

        <section class="our-mission">
            <div class="container">
                <h2 class="sub-title">Our Mission</h2>
                <p>Our mission is to revolutionize the industry with innovative solutions and exceptional service. We strive to exceed expectations and foster long-term relationships with our clients.</p>
            </div>
        </section>

        <section class="our-team">
            <div class="container">
                <h2 class="sub-title">Our Team</h2>
                <div class="team-members">
                    <div class="team-member">
                        <img src="https://via.placeholder.com/150" alt="Team Member 1" class="team-member-img">
                        <h3 class="team-member-name">Ali Mujtaba</h3>
                        <p class="team-member-role">CEO</p>
                    </div>
                    <div class="team-member">
                        <img src="https://via.placeholder.com/150" alt="Team Member 2" class="team-member-img">
                        <h3 class="team-member-name">Ahtisham ul Haq</h3>
                        <p class="team-member-role">CTO</p>
                    </div>
                    <div class="team-member">
                        <img src="https://via.placeholder.com/150" alt="Team Member 3" class="team-member-img">
                        <h3 class="team-member-name">Farooq Ahmed</h3>
                        <p class="team-member-role">COO</p>
                    </div>
                </div>
            </div>
        </section>


    </main>
@endsection
