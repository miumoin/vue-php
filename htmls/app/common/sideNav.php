<?php
    global $break, $start;
    $inside_program = false;
    if($break[$start+1] == 'programs' && isset($break[$start+2])){
        $inside_program = true;
    }

    if(!$inside_program){
?>
<ul class="main-menu">
    <li class="selected has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <div class="os-icon os-icon-layout"></div>
            </div>
            <span>Appearance</span>
        </a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">Appearance</div>

            <div class="sub-menu-icon">
                <i class="os-icon os-icon-layout"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    
                    <li>
                        <router-link to="/themes" >Themes</router-link>
                    </li>
                    <li>
                        <router-link to="/menus" >Menus</router-link>
                    </li>
                    <li>
                        <router-link to="/pages" >Pages</router-link>
                    </li>
                    <li>
                        <router-link to="/form-builder" >Form Builder</router-link>
                    </li>
                    
                </ul>
            </div>
        </div>
    </li>

    <li class="selected">
        <router-link to="/recruitments" >
            <div class="icon-w">
                <i class="fa fa-address-book-o" aria-hidden="true"></i>
            </div>
            <span>Recruitment</span>
        </router-link>
    </li>


    <li class="selected">
        <router-link to="/programs" >
            <div class="icon-w">
                <i class="fa fa-tasks" aria-hidden="true"></i>
            </div>
            <span>Program</span>
        </router-link>
    </li>


    <li class="selected has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <span>People</span>
        </a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">People</div>

            <div class="sub-menu-icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    <li>
                        <router-link to="/themes" >Role</router-link>
                    </li>
                    <li>
                        <router-link to="/menus" >People</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="selected has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <i class="fa fa-cog" aria-hidden="true"></i>
            </div>
            <span>Settings</span>
        </a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">Settings</div>

            <div class="sub-menu-icon">
                <i class="fa fa-cog" aria-hidden="true"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    <li>
                        <router-link to="/styles" >Styles</router-link>
                    </li>
                    <li>
                        <router-link to="/themes" >Language</router-link>
                    </li>
                    <li>
                        <router-link to="/menus" >Account</router-link>
                    </li>
                    <li>
                        <router-link to="/menus" >Domain</router-link>
                    </li>
                    <li>
                        <router-link to="/menus" >Payment</router-link>
                    </li>
                    <li>
                        <router-link to="/menus" >Profile</router-link>
                    </li>
                    <li>
                        <router-link to="/menus" >Email</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </li>


</ul>
<?php
    }else if($inside_program){
        $program_id = $break[$start+2];
?>
<ul class="main-menu">
    <li class="selected">
        <router-link to="/programs/events" >
            <div class="icon-w">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <span>Events</span>
        </router-link>
    </li>
    <li class="selected">
        <router-link to="/programs/events" >
            <div class="icon-w">
                <i class="fa fa-paint-brush" aria-hidden="true"></i>
            </div>
            <span>Appointment</span>
        </router-link>
    </li>
    <li class="selected">
        <router-link to="/programs/<?php echo $program_id;?>/courses" >
            <div class="icon-w">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
            </div>
            <span>Course Content</span>
        </router-link>
    </li>
    <li class="selected">
        <router-link to="/programs/events" >
            <div class="icon-w">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
            </div>
            <span>Office Hour</span>
        </router-link>
    </li>
    <li class="selected">
        <router-link to="/programs/events" >
            <div class="icon-w">
                <i class="fa fa-handshake-o" aria-hidden="true"></i>
            </div>
            <span>Weekly Report</span>
        </router-link>
    </li>
    <li class="selected">
        <router-link to="/programs/events" >
            <div class="icon-w">
                <i class="fa fa-cubes" aria-hidden="true"></i>
            </div>
            <span>Syllebus</span>
        </router-link>
    </li>
    <li class="selected">
        <router-link to="/programs/events" >
            <div class="icon-w">
                <i class="fa fa-comments-o" aria-hidden="true"></i>
            </div>
            <span>Feedback</span>
        </router-link>
    </li>
</ul>
<?php
    }
?>
