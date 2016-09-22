<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_permissions_tab")){
        echo "<script>window.close()</script>";
    }
?>


<style>
    #permissions_usertags_list_div{
        width: 150px;
        height: calc(100% - 42px);
        border-right: 1px solid #dddddd;
        float: left;
    }

    .permissions_usertag_list_div{
        text-align: center;
        cursor: pointer;
        padding: 10px;
    }
    .permissions_usertag_list_div:hover, .row_active{
        background: #dddddd;
    }

    #main_permissions_div{
        width: calc(100% - 150px);
        float: left;
        margin: 30px auto;
        padding: 0px 75px;
    }

    .permission_btn, #select_all, #select_none{
        border-style: none;
		border-radius: 8px;
		padding: 4px 6px;
		margin: 2px;
		outline: none;
		box-shadow: 1px 1px 3px;
    }
    .permission_btn[data-state=false]{
		color: black;
		background: #FF4F4F;
	}
	.permission_btn[data-state=true]{
		color: black;
		background: #00CC00;
	}
    #select_all, #select_none[data-state=false]{
		color: black;
		background: #FF4F4F;
	}
	#select_all, #select_none[data-state=true]{
		color: black;
		background: #00CC00;
	}
</style>

<div id="permissions_usertags_list_div">
    <center><br><span class="glyphicon glyphicon-tags"></span> User tags</center>
    <br>
    <?
        foreach(get_all_usertags_limited() as $value){
            if($value){
                echo "
                    <div class='permissions_usertag_list_div' data-id='$value->id'>
                        $value->name
                    </div>
                ";
            }
        }
    ?>
</div>
<div id="main_permissions_div">
    <center>
        <button id="select_all" data-state="true">Select all</button>
        <button id="select_none" data-state="false">Select none</button><br><br>
        <?
            echo "<span id='all_permissions' data-permissions='" . implode(";", $permissions) . "'></span>";

            function echoPermissions($beginsWith){
                foreach($GLOBALS["permissions"] as $value){
                    $name = $value;
                    $title = "";
                    if(isset($GLOBALS["permissionsInfo"][$value])){
                        $name = $GLOBALS["permissionsInfo"][$value]["name"];
                        $title = $GLOBALS["permissionsInfo"][$value]["desc"];
                    }
                    if(strpos($value, $beginsWith) === 0){
                        echo "<button class='permission_btn' data-name='$value' data-state='false' title='$title'>$name</button>";
                    }
                }
            }
        ?>

        <h4>Forums:</h4> <?echoPermissions("forums");?>
        <h4>Admin panel:</h4> <?echoPermissions("adminpnl");?>
    </center>
</div>

<script>
    var selectedUsertag = undefined
    var permissionstring = $("#all_permissions").data("permissions")
    activepermissionstring = ""
    $(".permissions_usertag_list_div").click(function(){ //when user clicks on one of the usertags
        $(".permissions_usertag_list_div").each(function(i, v){
            $(v).removeClass("row_active")
        })
        $(this).addClass("row_active")
        selectedUsertag = this

        $.get("requests/getusertagperms", {id: $(selectedUsertag).data("id")}, function(html){
            activepermissionstring = ""
            activepermissionstring = html
            $(".permission_btn").attr("data-state", "false")
            $(activepermissionstring.split(";")).each(function(i, value){
    			$("button[data-name='" + value + "']").attr("data-state", "true")
    		})
            if(activepermissionstring.indexOf("*;") > -1){
                $(".permission_btn").attr("data-state", "true")
    		}
        })
    })

    function postpermissions(){
		$.post("requests/setusertagperms", {permissions: activepermissionstring, usertag: $(selectedUsertag).data("id")})
	}

    $(".permission_btn").click(function(){
        var state = $(this).attr("data-state")
        var name = $(this).data("name")

        if(activepermissionstring.indexOf("*;") > -1){
            activepermissionstring = permissionstring + ";"
        }

        if(selectedUsertag != undefined){
            if(state == "true"){ //remove permission
                $(this).attr("data-state", "false")
                activepermissionstring = activepermissionstring.replace(new RegExp(name + ";", "g"), "")
            }else{
                $(this).attr("data-state", "true")
                if(!activepermissionstring.indexOf(name + ";") > -1){
					activepermissionstring = activepermissionstring + name + ";"
				}
                console.log(activepermissionstring.length-1, permissionstring.length)
				if(activepermissionstring.length-1 == permissionstring.length){
					activepermissionstring = "*;"
				}
            }
            postpermissions()
        }else{
            alert("You must first select a usertag from the left!")
        }
    })

    $("#select_all").click(function(){
        if(selectedUsertag != undefined){
            $(".permission_btn").attr("data-state", "true")
            activepermissionstring = "*;"
            postpermissions()
        }else{
            alert("You must first select a usertag from the left!")
        }
    })
    $("#select_none").click(function(){
        if(selectedUsertag != undefined){
            $(".permission_btn").attr("data-state", "false")
            activepermissionstring = ";"
            postpermissions()
        }else{
            alert("You must first select a usertag from the left!")
        }
    })
</script>
