let fields = [false, false, false, false, false, false, false, false,false];


    let fName = document.getElementById('fName');
    fName.addEventListener("keyup", () => {
        let pattern = /^[A-Z][a-z]{1,19}$/;
        if (pattern.test(fName.value)) {
            fName.classList.remove("border-red");
            fName.classList.add("border-green");
            fields[0] = true;
            function1();
        } else {
            fName.classList.remove("border-green");
            fName.classList.add("border-red");
            // fName.placeholder = "First Letter should be Upper Case";
            fields[0] = false;
            function1();
        }
    })

    let lName = document.getElementById('lName');
    lName.addEventListener("keyup", () => {
        let pattern = /^[A-Z][a-z]{1,19}$/;
        if (pattern.test(lName.value)) {
            lName.classList.remove("border-red");
            lName.classList.add("border-green");
            fields[1] = true;
            function1();
        } else {
            lName.classList.remove("border-green");
            lName.classList.add("border-red");
            fields[1] = false;
            function1();
        }
    })


    let nic = document.getElementById('nic');
    nic.addEventListener("keyup", () => {

        let pattern1 = /^[0-9]{9}[V]$/;
        let pattern2 = /^[0-9]{12}$/;
        if (pattern1.test(nic.value) || pattern2.test(nic.value)) {
            nic.classList.remove("border-red");
            nic.classList.add("border-green");
            fields[2] = true;
            function1();
        } else {
            nic.classList.remove("border-green");
            nic.classList.add("border-red");
            fields[2] = false;
            function1();
        }
    })
//199684502894
    let lane1 = document.getElementById('lane1');
    lane1.addEventListener("keyup", () => {
        let pattern = /^[A-Za-z0-9-/]{1,19}$/;
        if (pattern.test(lane1.value)) {
            lane1.classList.remove("border-red");
            lane1.classList.add("border-green");
            fields[3] = true;
            function1();
        } else {
            lane1.classList.remove("border-green");
            lane1.classList.add("border-red");
            fields[3] = false;
            function1();
        }
    })

    let lane2 = document.getElementById('lane2');
    lane2.addEventListener("keyup", () => {
        let pattern = /^[A-Z][a-z]{1,200}$/;
        if (pattern.test(lane2.value)) {
            lane2.classList.remove("border-red");
            lane2.classList.add("border-green");
            fields[4] = true;
            function1();
        } else {
            lane2.classList.remove("border-green");
            lane2.classList.add("border-red");
            fields[4] = false;
            function1();
        }
    })

    let lane3 = document.getElementById('lane3');
    lane3.addEventListener("keyup", () => {
        let pattern = /^[A-Z][a-z]{1,200}$/;
        if (pattern.test(lane3.value)) {
            lane3.classList.remove("border-red");
            lane3.classList.add("border-green");

        } else {
            lane3.classList.remove("border-green");
            lane3.classList.add("border-red");
        }
    })

    let mobNo = document.getElementById('mob-no');
    mobNo.addEventListener("keyup", () => {
        let pattern = /^[0][7][0,1,2,5,6,7,8][0-9]{7,}$/;
        if (pattern.test(mobNo.value)) {
            mobNo.classList.remove("border-red");
            mobNo.classList.add("border-green");
            fields[5] = true;
            function1();
        } else {
            mobNo.classList.remove("border-green");
            mobNo.classList.add("border-red");
            fields[5] = false;
            function1();
        }
    })

    let mobNo2 = document.getElementById('mob-no2');
    mobNo2.addEventListener("keyup", () => {
        let pattern = /^[0][1,3,7][0-9]{8,}$/;
        if (pattern.test(mobNo2.value)) {
            mobNo2.classList.remove("border-red");
            mobNo2.classList.add("border-green");
            
        } else {
            mobNo2.classList.remove("border-green");
            mobNo2.classList.add("border-red");
        }
    })

    let email = document.getElementById('email');
    email.addEventListener("keyup", () => {
        // let pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let pattern=/^[a-z0-9](\.?[a-z0-9]){5,}@g(oogle)?mail\.com$/;
        if (pattern.test(email.value)) {
            email.classList.remove("border-red");
            email.classList.add("border-green");
            fields[6] = true;
            function1();
        } else {
            email.classList.remove("border-green");
            email.classList.add("border-red");
            fields[6] = false;
            function1();
        }
    })



    // function dobValidate(){
    //     let dob = document.getElementById('dob');
    //     var GivenDate = dob.value;
    //     var CurrentDate = new Date();
    //     GivenDate = new Date(GivenDate);

    //     if (GivenDate < CurrentDate) {
    //         dob.classList.remove("border-red");
    //         dob.classList.add("border-green");
    //         fields[8] = true;
    //         function1();
    //     } else {
    //         dob.classList.remove("border-green");
    //         dob.classList.add("border-red");
    //         fields[8] = false;
    //         function1();
    //     }

    // }

    const selectElement = document.querySelector('select');
    let gen=document.getElementById('gender');

     selectElement.addEventListener('change', function(event) {
         const selectedOption = event.target.value;
         if(selectedOption=="Male" || selectedOption=="Female" || selectedOption=="Other"){
             gen.classList.remove("border-red");
             gen.classList.add("border-green");
             fields[8] = true;
             function1();

         }else{
             gen.classList.remove("border-green");
             gen.classList.add("border-red");
             fields[8] = false;
             function1();
         }
     });
    



    let role1 = document.getElementById('role1');
    role1.addEventListener('click', () => {
        fields[7] = true;
        function1();
    })

    let role2 = document.getElementById('role2');
    role2.addEventListener('click', () => {
        fields[7] = true;
        function1();
    })

    let role3 = document.getElementById('role3');
    role3.addEventListener('click', () => {
        fields[7] = true;
        function1();
    })

    function function1() {
        let addBtn = document.getElementById('registerbtn');
        if (fields[0] && fields[1] && fields[2] && fields[3] && fields[4] && fields[5] && fields[6] && fields[7] && fields[8]) {
            addBtn.classList.remove("button-visibility");

        } else {
            addBtn.classList.add("button-visibility");
        }
    }