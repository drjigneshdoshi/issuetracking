<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <? if(IsAdministrator()) : ?>
           <li>
                <a href="home"><i class="fa fa-dashboard fa-fw nav_icon"></i>Dashboard</a>
            </li>
                <li>
                    <a href="#"><i class="fa fa-laptop nav_icon"></i>Manage User<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href=<?=BaseURLConcat("AddMember")?>>Add New Member</a>
                        </li>
                        <li>
                            <a href=<?=BaseURLConcat("ManageMembers")?>>Manage Members</a>
                        </li>
                    </ul>
                </li>
            <? endif; ?>


                <li>
                    <a href="#"><i class="fa fa-indent nav_icon"></i>Manage Case<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <? if(IsAdministrator() || IsLabAssistant()):?>
                            <li>
                                <a href="LatestCase">Latest Case </a>
                            </li>
                            <li>
                                <a href="AssignedCase">Assigned Case </a>
                            </li>
                        <? endif; ?>
                        <? if(IsUser()):?>
                            <li>
                                <a href="CreateCase">Create Case</a>
                            </li>
                            <li>
                                <a href="CheckCases">Check Case</a>
                            </li>
                        <? endif; ?>
                    </ul>
                </li>

            <li>
                <a href="Actions/logout.php"><i class="fa fa-user fa-fw nav_icon"></i>Logout</a>
            </li>
        </ul>
    </div>
</div>
