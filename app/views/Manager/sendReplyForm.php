<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

.page-reply-complaint{
    font-family: 'Poppins',sans-serif;
    position: absolute;
    top:0;
    display:flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height:100%; 
    backdrop-filter: blur(10px);
    z-index: 10;
    
    
}

.entire-complaint-reply{
    display: flex;
    flex-direction: column;
    width: 100%;
}

.content-reply-complaint{
    background-color: white;
    display: flex;
    /* border: 2px solid goldenrod; */
    padding:20px;
    border-radius: 20px;
    box-shadow: 0 4px 8px 4px rgba(0,0,0,0.2);  

}


.complaint-reply-group{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.complaint-reply-group p{
    width: 100%;
    border:none;
    outline: none;
    border-radius: 10px;
    padding: 10px 30px;
    margin: 10px;
    background-color: blanchedalmond;
}

.complaint-reply-group textarea{
    width: 100%;
    border:none;
    outline: none;
    border-radius: 10px;
    padding: 5px 10px;
    margin: 10px;
    background-color: blanchedalmond;
}

.complaint-reply-group label{
    font-size: x-large;
}

.twoButtons{
    display: flex;
    flex-direction: column;

}

.twoButtons .ok-btn{
    width:100%;
     border:none;
     padding: 10px 100px;
     font-size: medium;
     color:white;
     /* background-color: rgb(32, 218, 60); */
     border-radius: 10px;
     text-decoration: none;
     margin-top: 10px;
     width: 100%;
     background-color: #bb8a04;
    
}

.twoButtons .cancel-btn{  
    width:100%;
    border: 2px solid #bb8a04;
    padding: 7px 40px;
    font-size: medium;
    color:#bb8a04;
    background-color: white;
    border-radius: 10px;
    margin-top: 10px;
    width: 100%;

} 
     
</style>


<div style="display:none;" class="page-reply-complaint" id="send-reply-form">
                <div class="content-reply-complaint">
                        <form action="<?php echo URLROOT ?>/mgDashboard/sendReplyForComplaints" method="POST" class="entire-complaint-reply" id="password-popup-form">
                           <div class="complaint-reply-group">
                                <label><b>Reply Message</b></label>
                                <p id="msg" value="" class="msg"></p>
                                <textarea id="text-area" placeholder="Type Your Reply Here.." name="text-area" rows="6" cols="35"></textarea>
                            </div>
                           
                            <div class="twoButtons">
                                <button type="submit" id="ok-btn" class="ok-btn">Reply</button>
                                <button type="button" id="cancelButton" class="cancel-btn">Cancel</button>
                            </div>
                            <input type="hidden" value="" name="cusId" id="cusId"/>
                        </form>
                   
                </div>
    </div>

   