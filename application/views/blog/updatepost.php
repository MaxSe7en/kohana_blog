<?php
require_once('config.php')
?>
<?php
require_once('includes/head.php')
?>
<title>Update Post</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar fixed-top navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="<?php echo BASE_URL ?>">MY BLOG</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL ?>">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="animate">
        <p class="loading"></p>
        <h1 class="messages"></h1>
        <p class="error"></p>
    </div>
    <div class="container mt-5">
        <h1 class='text-center push-down mt-5'>Please Update Your Blog Below</h1>
        <?php foreach ($posts as $post) { ?>
            <h1><?php $post['body'] ?></h1>
            <form method="post" id='form'>
                <p>
                <br />
                <input readonly type="hidden" name="title" id="id" value="<?php echo $post['id'] ?>" class="form-control bg-dark text-white my-3 text-center">
                </p>
                <p>
                <h2 for="title">Title</h2><br />
                <input type="text" name="title" id="title" aria-describedby="inputGroup-sizing-default" value="<?php echo $post['title'] ?>" class="form-control text-white bg-dark  my-3 text-center">
                </p>
                <p>
                <h2 for="title">Body</h2><br />
                <textarea rows='10' name="body" id="body" value='sdfsfsad' class='form-control  text-white bg-dark my-3'><?php echo $post['body'] ?></textarea>
                </p>
                <button class='btn btn-success mt-3 btn-lg'>Update Post</button>
            </form>
        <?php } ?>
        <h2 id='message'></h2>
    </div>


    <?php
    require_once('includes/footer.php')
    ?>

    <script>
        let title = document.getElementById('title');
        let body = document.getElementById('body');
        let form = document.getElementById('form');
        let id = document.getElementById('id');
        let messageResponse = document.getElementById('message');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            submitBlog();
        })
        //LOADER ANIMATION
        const getAnimation = document.querySelector(".animate");

        const messages = document.querySelector(".messages");
        const ifError = document.querySelector(".error");
        const Loading = document.querySelector(".loading");

        function isLoading() {
            getAnimation.classList.add("active");
            Loading.classList.add("active");
            messages.innerText = "";
            messages.classList.add("active");
        }
        async function submitBlog() {
         
            //LOOPING THROUGH  THE USERS TO FIND MATCH
            try {
                isLoading();

                const idValue = id.value.trim();
                const titleValue = title.value.trim();
                const bodyValue = body.value.trim();

                const blogs = {
                    title: titleValue,
                    body: bodyValue,
                    id: idValue
                };

                const URL = "https://dreamerslake.com/kohana/api/update_post.php";
                const options = {
                    method: "POST",
                    body: JSON.stringify(blogs),
                };
                console.log(`URL==========>${URL}`);
                const response = await fetch(URL, options);
                console.log();

                const blogData = await response.json();
                const useTheData = await blogData;
                const {
                    status,
                    message
                } = await useTheData;
                if (status === 200) {
                    Loading.classList.remove("active");
                    messages.classList.remove("active");
                    const text = `${message}. Redirecting now...`;
                    messages.innerText = text;
                    console.log(message);
                    setTimeout(() => {
                        // window.location.reload;
                        window.location.replace('/kohana/blog');
                    }, 1000);
                } else {
                    ifError.classList.remove("active");
                    Loading.classList.remove("active");
                    messages.classList.remove("active");
                    const text = `${message}`;
                    messages.innerText = text;
                    setTimeout(removeLoader, 2000);
                    console.log(message);
                }
            } catch (error) {
                Loading.classList.remove("active");
                const text = `Ooops...Something went wrong.`;
                setTimeout(() => {
                    getAnimation.classList.remove("active");
                }, 4000);
            }


        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>

</html>