<?php require APPROOT . "/views/inc/header.php" ?>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT ?>/css/nav-bar.css'>
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo URLROOT ?>/css/newAllocation.css'>
<title>Vogue | New Allocation</title>
</head>

<body class="wrapper">

    <div class="">
        <div class="right-heading">
            <div class="right-side">
                <a href="<?php echo URLROOT ?>/VKDashboard/dashboard" id="back">
                    <img class="back" src="<?php echo URLROOT ?>/img/back.png" alt="back">
                </a>
                <h1 id="title">New Allocation</h1>
            </div>
            <img class="vogue" src="<?php echo URLROOT ?>/img/FULLlogo.png" alt="logo">
        </div>

    </div>
    <?php notification('validation') ?>
    <form class="content" method="Post" action="<?php echo URLROOT ?>/LockerValidation/validation/<?php if (!empty($data['appointment'])) {
                                                                                                        echo $data['appointment'];
                                                                                                    } else {
                                                                                                        echo "0";
                                                                                                    } ?>">
        <div class="validation-img">
            <?php if (empty($data['appointment'])) :
                if (empty($data['customerId'])) : ?>
                    <div class="search-container" method="post" action="<?php echo URLROOT ?>/LockerValidation/getCustomer">
                        <input type="text" name="" id="search" placeholder="Enter CustomerId or NIC">
                        <button type="button" class="search-icon" id="searchbtn" onclick="searchCustomer()"></button>
                    </div>
                <?php endif; ?>
            <?php else : ?>

                <label for="">Appointment Number</label>
                <input type="text" name="appointment" id="appointment" value="<?php echo $data['appointment'] ?>" readonly>


            <?php endif; ?>
            <span class="error" id="error"></span>
            <img src="<?php echo URLROOT ?>/img/Web search-cuate.svg" alt="">
        </div>
        <div class="cus-details">
            <h2>Customer Details</h2>
            <div class="info-section">
                <label for="id">Customer Id</label>
                <input type="text" name="id" id="id" value="<?= $data['customerId'] ?>" readonly>
            </div>
            <div class="info-section">
                <label for="fname">Name</label>
                <input type="text" name="name" id="fname" value="<?= $data['name'] ?>" readonly>
            </div>
            <div class="info-section">
                <label for="Phone">Phone Number</label>
                <input type="text" name="phone" id="Phone" value="<?= $data['phone'] ?>" readonly>
            </div>
            <div class="info-section">
                <label for="NIC">NIC</label>
                <input type="text" name="nic" id="NIC" value="<?= $data['nic'] ?>" readonly>
            </div>
        </div>
        <div class="article-details">
            <h2>Article Details</h2>
            <div class="info-section">
                <label for="">Article type</label>
                <select name="article_type">
                    <option value="Ring" <?php echo ($data['article_type'] == "Ring") ? 'selected' : '' ?>>Ring</option>
                    <option value="Necklace" <?php echo ($data['article_type'] == "Necklace") ? 'selected' : '' ?>>Necklace</option>
                    <option value="Earing" <?php echo ($data['article_type'] == "Earing") ? 'selected' : '' ?>>Earing</option>
                    <option value="Gold Bar" <?php echo ($data['article_type'] == "Gold Bar") ? 'selected' : '' ?>>Gold Bar</option>
                    <option value="Biscuit" <?php echo ($data['article_type'] == "Biscuit") ? 'selected' : '' ?>>Biscuit</option>
                    <option value="Bracelet" <?php echo ($data['article_type'] == "Bracelet") ? 'selected' : '' ?>>Bracelet</option>
                    <option value="Anklet" <?php echo ($data['article_type'] == "Anklet") ? 'selected' : '' ?>>Anklet</option>
                    <option value="Brooche" <?php echo ($data['article_type'] == "Brooche") ? 'selected' : '' ?>>Brooche</option>

                </select>
            </div>
            <div class="info-section">
                <label for="img">Article Image</label>
                <input type="file" name="img" id="img">
                <input type="hidden" id="imageData" name="image">
            </div>
            <!-- <div class="info-section" > -->
            <div class="buttion-container">
                <button type="submit" name="Add_another" class="btn sub">
                    <h3>+ Add Another</h3>
                </button>
                <button type="submit" name="validation_btn" class="btn">Submit</button>
            </div>



        </div>

    </form>




    </div>
    <script>
        let validation_btn = document.getElementById("validation_btn");
        const fileInput = document.getElementById('img');

        var searchid = document.getElementById('search');
        var error = document.getElementById('error');
        var id = document.getElementById('id');

        // image set
        let imageChooser = document.getElementById('img');
        let image = '';
        imageChooser.addEventListener('change', () => {
            file = imageChooser.files[0];
            if (file) {
                const fileReader = new FileReader(); //create an object using FileReader class
                fileReader.readAsDataURL(file);
                fileReader.addEventListener('load', () => {
                    image = fileReader.result;
                    // document.getElementById('profile-pic').src = image;
                    document.getElementById('imageData').value = image;
                })
            }
        })


        validation_btn.addEventListener('click', function(event) {
            // $.ajax({
            //     type: "POST",
            //     url: "<?= URLROOT ?>/CustomerPawn/getTimeSlots",
            //     data: {
            //         date: selectedDate
            //     },
            //     dataType: "JSON",
            //     success: function(response) {


            //     },
            //     error: function(xhr, status, error) {
            //         console.log("Error: " + error);
            //     }
            // });



        });
        if ('<?php echo $data['appointment'] ?>' == '') {
            searchid.addEventListener('change', function(event) {
                error.innerHTML = '';
                document.getElementById('id').value = "";
                document.getElementById('fname').value = "";
                document.getElementById('Phone').value = "";
                document.getElementById('NIC').value = "";


            });
        }
        // Define the searchCustomer function
        function searchCustomer() {

            var customerid = searchid.value;
            error.innerHTML = '';
            setnullfields();
            // Define a regular expression to match
            var regex = /^([Cc][Uu]\d+|\d{12}|\d{10}[Vv])$/;
            // Test if the customer ID matches the regular expression
            if (regex.test(customerid)) {
                // Convert the customer ID to uppercase
                searchid.value = customerid.toUpperCase();

                $.ajax({
                    type: "GET",
                    url: "<?= URLROOT ?>/LockerValidation/getCustomer",
                    data: {
                        customerid: customerid
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (!response || response.length === 0) {
                            error.innerHTML = '*Not Registered as a customer';

                        } else {
                            document.getElementById('id').value = response.UserId;
                            document.getElementById('fname').value = response.First_Name + " " + response.Last_Name;
                            document.getElementById('Phone').value = response.phone;
                            document.getElementById('NIC').value = response.NIC;

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error);
                    }
                });
            } else {

                error.innerHTML = '*Invalid Details';

            }

        }

        function setnullfields() {
            // Set input fields in cus-details to null
            document.querySelectorAll('.cus-details input[type="text"]').forEach(input => {
                input.value = '';
            });

            // Set input fields in article-details to null
            document.querySelectorAll('.article-details input[type="text"], .article-details input[type="file"]').forEach(input => {
                input.value = '';
            });

            // Reset article_type select field to the first option
            document.querySelector('.article-details select[name="article_type"]').selectedIndex = 0;
        }
    </script>
    <?php require APPROOT . "/views/inc/footer.php" ?>