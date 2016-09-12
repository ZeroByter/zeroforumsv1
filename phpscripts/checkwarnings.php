<style>
    .warning_cover{
        position: fixed;
        top: 0px;
        left: 0px;
        background: rgba(117, 117, 117, 0.67);
        width: 100%;
        height: 100%;
        z-index: 10;
    }

    .warning_body_div{
        margin: 100px auto;
        width: 75%;
    }
</style>

<?
    //This file checkes for BOTH warnings AND bans! I just thought 'checkwarningsandbans.php' is too long of a file title.
    $htmlString = "";
    $warningsHtml = "";
    $banHtml = "";

    $currentAccount = get_current_account();
    if($currentAccount !== null){
        $warnings = get_user_warnings($currentAccount->id);
        if(count($warnings) > 0 || $currentAccount->bannedby > 0){ // or if banned
            if($currentAccount->bannedby > 0){ // if is banned
                $bannedOn = $currentAccount->bannedtime;
                $bannedBy = get_account_display_name($currentAccount->bannedby);
                $bannedReason = $currentAccount->bannedmsg;

                $nowtime = new DateTime();
                $unbantime = new DateTime();
                date_timestamp_set($unbantime, $currentAccount->unbantime);
                $interval = $unbantime->diff($nowtime);
                $bantimeleft = $interval->format("%a days, %h hours, %i minutes, %s seconds");

                $banHtml = $banHtml . "
                    You have been banned: $bannedReason<br>
                    Ban issued on $bannedOn by $bannedBy<br>
                    Ban time remaining: $bantimeleft<br>
                    <button type='button' class='btn btn-primary' id='okay_ban'>Okay</button><br><br>
                "; //add banned stuff here
            }
            if(count($warnings) > 0){ //if has warnings
                $warningsHtml = $warningsHtml . "You have been issued the following warnings:<br>";
                foreach($warnings as $value){
                    $warnedBy = get_account_display_name(get_account_by_id($value->warnedby)->id);
                    $warningTime = get_human_time($value->time);
                    $warningsHtml = $warningsHtml . "
                        <p>By $warnedBy $warningTime ago<br>
                        $value->message</p>
                    ";
                }
                $warningsHtml = $warningsHtml . "<button type='button' class='btn btn-primary' id='okay_warnings'>Acknowledge warnings</button>";
            }

            $htmlString = $htmlString . "<div class='warning_cover'>
                <div class='panel panel-default warning_body_div'>
                    <div class='panel-heading'>Attention!</div>
                    <div class='panel-body'>
                        $banHtml
                        $warningsHtml
                    </div>
                </div>
            </div>";
            //this dude has some warnings!
        }
    }

    echo $htmlString;
?>

<script>
    $("#okay_warnings").click(function(){
        $(".warning_cover").remove()
        $.get("/phpscripts/requests/okaywarnings", function(html){
            console.log(html)
        })
    })

    $("#okay_ban").click(function(){
        $(".warning_cover").remove()
    })
</script>
