<?php
    function forums_create_db(){
        $conn = sql_connect();
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS forums(
            id int(6) NOT NULL auto_increment,
            views int(6) NOT NULL,
            firstposted int(8) NOT NULL,
            lastactive int(8) NOT NULL,
            lastedited int(8) NOT NULL,
            lastediteduser int(6) NOT NULL,
            type varchar(32) NOT NULL,
            name varchar(64) NOT NULL,
            posttext text NOT NULL,
            poster int(6) NOT NULL,
            parent int(6) NOT NULL,
            listorder int(6) NOT NULL,
            canview text NOT NULL,
            canpost text NOT NULL,
            canedit text NOT NULL,
            locked boolean NOT NULL,
            hidden boolean NOT NULL,
            pinned boolean NOT NULL,
            global boolean NOT NULL,
            PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
        mysqli_close($conn);

        //types can be:
        //  forum, subforum, thread, reply
    }

    function get_all_forums(){
        $conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE type='forum' ORDER BY listorder ASC");
		mysqli_close($conn);

        if(mysqli_num_rows($result) === 0){
            return array();
        }else{
            while($array[] = mysqli_fetch_object($result));
            return $array;
        }
    }

    function get_all_subforums($parent){
        $conn = sql_connect();
        $parent = mysqli_real_escape_string($conn, $parent);
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE type='subforum' && parent='$parent' ORDER BY listorder ASC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_all_threads($parent){
        $conn = sql_connect();
        $parent = mysqli_real_escape_string($conn, $parent);
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' && parent='$parent' ORDER BY lastactive DESC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_all_pinned_threads($parent){
        $conn = sql_connect();
        $parent = mysqli_real_escape_string($conn, $parent);
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' && pinned='1' && parent='$parent' ORDER BY lastactive DESC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_all_replies($parent){
        $conn = sql_connect();
        $parent = mysqli_real_escape_string($conn, $parent);
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE type='reply' && parent='$parent' ORDER BY lastactive DESC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_last_thread($parent=0){
        $conn = sql_connect();
        $parent = mysqli_real_escape_string($conn, $parent);
        if($parent == 0){
            $result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' ORDER BY lastactive DESC");
        }else{
            if(tag_has_permission(get_current_usertag(), "forums_threadhideunhide")){
                $result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' && parent='$parent' ORDER BY lastactive DESC");
            }else{
                $result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' && hidden='0' && parent='$parent' ORDER BY lastactive DESC");
            }
        }
		mysqli_close($conn);

        return mysqli_fetch_object($result);
    }

    function get_lastest_threads($parent=0){
        $conn = sql_connect();
        $parent = mysqli_real_escape_string($conn, $parent);
        if($parent == 0){
            $result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' ORDER BY lastactive DESC LIMIT 10");
        }else{
            $result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' && parent='$parent' ORDER BY lastactive DESC LIMIT 10");
        }
		mysqli_close($conn);

        while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_forum_by_id($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE id='$id'");
		mysqli_close($conn);

        return mysqli_fetch_object($result);
    }

    function get_num_threads_by_poster($poster){
        $conn = sql_connect();
        $poster = mysqli_real_escape_string($conn, $poster);
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE type='thread' && poster='$poster'");
		mysqli_close($conn);

        return mysqli_num_rows($result);
    }

    function get_all_posts_by_poster($poster){
        $conn = sql_connect();
        $poster = mysqli_real_escape_string($conn, $poster);
		$result = mysqli_query($conn, "SELECT * FROM forums WHERE poster='$poster' && type='thread' || poster='$poster' && type='reply' ORDER BY firstposted DESC");
		mysqli_close($conn);

        while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_forums_can_perms($id, $type){
        if($type == "canview" || $type == "canpost" || $type == "canedit"){
            $conn = sql_connect();
            $id = mysqli_real_escape_string($conn, $id);
            $type = mysqli_real_escape_string($conn, $type);
    		$result = mysqli_query($conn, "SELECT $type FROM forums WHERE id='$id'");
    		mysqli_close($conn);

            return mysqli_fetch_object($result)->$type;
        }
    }

    function set_forums_can_perms($id, $type, $permissions){
        if($type == "canview" || $type == "canpost"){
            $conn = sql_connect();
            $id = mysqli_real_escape_string($conn, $id);
            $type = mysqli_real_escape_string($conn, $type);
            $permissions = mysqli_real_escape_string($conn, $permissions);
    		$result = mysqli_query($conn, "UPDATE forums SET $type='$permissions' WHERE id='$id'");
    		mysqli_close($conn);
        }
    }

    function forums_create_forum($name, $posttext, $listorder, $canview="all", $canpost="all", $canedit="all"){
        $conn = sql_connect();
		$name = mysqli_real_escape_string($conn, $name);
		$posttext = mysqli_real_escape_string($conn, $posttext);
		$listorder = mysqli_real_escape_string($conn, $listorder);
        $poster = get_current_account()->id;
		$canview = mysqli_real_escape_string($conn, $canview);
		$canpost = mysqli_real_escape_string($conn, $canpost);
		$canedit = mysqli_real_escape_string($conn, $canedit);
		$time = time();
		mysqli_query($conn, "INSERT INTO forums(firstposted, lastactive, type, name, posttext, listorder, poster, canview, canpost, canedit) VALUES ('$time', '$time', 'forum', '$name', '$posttext', '$listorder', '$poster', '$canview', '$canpost', '$canedit')");
		mysqli_close($conn);
    }

    function forums_create_subforum($parent, $name, $posttext, $listorder, $canview="all", $canpost="all", $canedit="all"){
        $conn = sql_connect();
		$parent = mysqli_real_escape_string($conn, $parent);
		$name = mysqli_real_escape_string($conn, $name);
		$posttext = mysqli_real_escape_string($conn, $posttext);
		$listorder = mysqli_real_escape_string($conn, $listorder);
        $poster = get_current_account()->id;
		$canview = mysqli_real_escape_string($conn, $canview);
		$canpost = mysqli_real_escape_string($conn, $canpost);
		$canedit = mysqli_real_escape_string($conn, $canedit);
		$time = time();
		mysqli_query($conn, "INSERT INTO forums(parent, firstposted, lastactive, type, name, posttext, listorder, poster, canview, canpost, canedit) VALUES ('$parent', '$time', '$time', 'subforum', '$name', '$posttext', '$listorder', '$poster', '$canview', '$canpost', '$canedit')");
		mysqli_close($conn);
    }

    function forums_update_lastactive($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
        $time = time();
		$result = mysqli_query($conn, "UPDATE forums SET lastactive='$time' WHERE id='$id'");
		mysqli_close($conn);
    }

    function forums_create_reply($thread, $text){
        $conn = sql_connect();
        $thread = mysqli_real_escape_string($conn, $thread);
        $text = mysqli_real_escape_string($conn, $text);
        $poster = get_current_account()->id;
        $time = time();
		$result = mysqli_query($conn, "INSERT INTO forums(firstposted, type, posttext, poster, parent) VALUES ('$time', 'reply', '$text', '$poster', '$thread')");
		mysqli_close($conn);
    }

    function forums_create_thread($subforum, $subject, $body){
        $conn = sql_connect();
        $subforum = mysqli_real_escape_string($conn, $subforum);
        $subject = mysqli_real_escape_string($conn, $subject);
        $body = mysqli_real_escape_string($conn, $body);
        $poster = get_current_account()->id;
        $time = time();
		$result = mysqli_query($conn, "INSERT INTO forums(firstposted, lastactive, type, name, posttext, poster, parent) VALUES ('$time', '$time', 'thread', '$subject', '$body', '$poster', '$subforum')");
        $lastcreatedid = mysqli_insert_id($conn);
		mysqli_close($conn);
        return $lastcreatedid;
    }

    function thread_toggle_lock($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "UPDATE forums SET locked = NOT locked WHERE id='$id'");
		mysqli_close($conn);
    }

    function thread_toggle_pin($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "UPDATE forums SET pinned = NOT pinned WHERE id='$id'");
		mysqli_close($conn);
    }

    function thread_toggle_hidden($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "UPDATE forums SET hidden = NOT hidden WHERE id='$id'");
		mysqli_close($conn);
    }

    function thread_delete($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "DELETE FROM forums WHERE id='$id'");
		$result = mysqli_query($conn, "DELETE FROM forums WHERE parent='$id'");
		mysqli_close($conn);
    }

    function forum_delete($id){
        $repliesarray = array();
        $threadsarray = array();
        $subforumsarray = array();

        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$subforums = mysqli_query($conn, "SELECT * FROM forums WHERE parent='$id'");
        while($subforumsarray[] = mysqli_fetch_object($subforums));

        foreach($subforumsarray as $value){
            if($value){
                $threads = mysqli_query($conn, "SELECT * FROM forums WHERE parent='$value->id'");
                while($threadsarray[] = mysqli_fetch_object($threads));
                mysqli_query($conn, "DELETE FROM forums WHERE id='$value->id'");
            }
        }
        foreach($threadsarray as $value){
            if($value){
                $replys = mysqli_query($conn, "SELECT * FROM forums WHERE parent='$value->id'");
                while($repliesarray[] = mysqli_fetch_object($replys));
                mysqli_query($conn, "DELETE FROM forums WHERE id='$value->id'");
            }
        }
        foreach($repliesarray as $value){
            if($value){
                mysqli_query($conn, "DELETE FROM forums WHERE id='$value->id'");
            }
        }

        mysqli_query($conn, "DELETE FROM forums WHERE id='$id'");

        mysqli_close($conn);
    }

    function subforum_delete($id){
        $repliesarray = array();
        $threadsarray = array();

        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
        $threads = mysqli_query($conn, "SELECT * FROM forums WHERE parent='$id'");
        while($threadsarray[] = mysqli_fetch_object($threads));

        foreach($threadsarray as $value){
            if($value){
                $replys = mysqli_query($conn, "SELECT * FROM forums WHERE parent='$value->id'");
                while($repliesarray[] = mysqli_fetch_object($replys));
                mysqli_query($conn, "DELETE FROM forums WHERE id='$value->id'");
            }
        }
        foreach($repliesarray as $value){
            if($value){
                mysqli_query($conn, "DELETE FROM forums WHERE id='$value->id'");
            }
        }

        mysqli_query($conn, "DELETE FROM forums WHERE id='$id'");

        mysqli_close($conn);
    }

    function forum_edit($id, $name, $posttext, $listorder){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
        $name = mysqli_real_escape_string($conn, $name);
        $posttext = mysqli_real_escape_string($conn, $posttext);
        $listorder = mysqli_real_escape_string($conn, $listorder);
		$result = mysqli_query($conn, "UPDATE forums SET name='$name',posttext='$posttext',listorder='$listorder' WHERE id='$id'");
		mysqli_close($conn);
    }

    function thread_edit($id, $subject, $body){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
        $subject = mysqli_real_escape_string($conn, $subject);
        $body = mysqli_real_escape_string($conn, $body);
        $currAccount = get_current_account();
		$result = mysqli_query($conn, "UPDATE forums SET name='$subject',posttext='$body',lastedited='".time()."',lastediteduser='".$currAccount->id."' WHERE id='$id'");
		mysqli_close($conn);
    }

    function reply_edit($id, $body){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
        $body = mysqli_real_escape_string($conn, $body);
        $currAccount = get_current_account();
		$result = mysqli_query($conn, "UPDATE forums SET posttext='$body',lastedited='".time()."',lastediteduser='".$currAccount->id."' WHERE id='$id'");
		mysqli_close($conn);
    }
?>
