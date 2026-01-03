<nav class="navbar px-4">
    <div class="icons login col-md-12">
        <div class="headimg">
            <a href="{{ route('settings') }}"><img src="{{ asset('assets/images/setting.png') }}" height="25px" alt=""></a>
        </div>
        <?php //echo $dlr_db;
        ?>
        <!-- <div class="headimg">
            <a href=""><img src="./images/bell.png" height="25px" alt=""></a>
        </div> -->
        <div class="user">
            <img src="{{ asset('assets/images/avatar.png') }}" height="40px" class="rounded-5" alt="">
            <h6 class="bg-white px-3 py-1 m-0 rounded-2"><?php echo $emp_name ?? 'name'; ?></h6>
        </div>
        <button class="border-0 m-0 p-0 responsive_button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            <span id="navigation-icon" style=" font-size:25px;cursor:pointer">&#9776;</span>
        </button>
    </div>
</nav>
