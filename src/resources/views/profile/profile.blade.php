@extends(config('kregel.auth-login.base-layout'))
@section('content')
<style>
    .user-profile{
        background:url(https://unsplash.it/1500/500?random=1);
        background-size:cover;
        height:400px;
        width:100%;
    }
</style>
<section class="user-profile">
    <header class="profile-header">
        <!-- Some Random image -->
    </header>
    <section class="profile-main">
        <aside class="profile-image">
            <img src="https://placehold.it/150x150" alt="">
        </aside>
    </section>
</section>
@endsection