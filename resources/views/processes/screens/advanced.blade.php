<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $screen->title }}</title>
    <!--Do Not Delete Below -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        (function () {
            /** LOAD_PM_VARIABLES **/
            window.ProcessMaker = {
                apiToken: PM_API_TOKEN,
                submitUrl: PM_SUBMIT_URL,
                requestData: PM_REQUEST_DATA,
                completeTask: PM_FN_COMPLETE_TASK,
            }
        })();
    </script>
    <!--Do Not Delete Above -->
</head>

<body>
    <div class="card" style="width: 28rem;">
        <div class="card-body">
            <form onsubmit="return ProcessMaker.completeTask(this)">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the content.</p>
                <div><input name="firstname" class="form-control" placeholder="firstname"></div>
                <button type="submit" class="btn btn-primary">Complete Task</button>
            </form>
        </div>
    </div>
</body>

</html>
