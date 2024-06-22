<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Streaming App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Live Streaming App</h1>
    <form id="streamForm" method="POST" action="{{ route('startStream') }}">
        @csrf
        <div id="streams">
            <div class="mb-3">
                <label for="streamKey" class="form-label">Stream Key</label>
                <input type="text" class="form-control" id="streamKey" name="streams[0][streamKey]" required>
            </div>
            <div class="mb-3">
                <label for="videoname" class="form-label">Video Name (e.g., rain.mp4)</label>
                <input type="text" class="form-control" id="videoname" name="streams[0][videoname]" required>
            </div>
        </div>
        <button type="button" class="btn btn-primary" onclick="addStream()">Add Stream</button>
        <button type="submit" class="btn btn-success">Start Streaming</button>
    </form>
</div>

<script>
    let streamIndex = 1;

    function addStream() {
        let html = `
            <div class="mb-3">
                <label for="streamKey${streamIndex}" class="form-label">Stream Key</label>
                <input type="text" class="form-control" id="streamKey${streamIndex}" name="streams[${streamIndex}][streamKey]" required>
            </div>
            <div class="mb-3">
                <label for="videoname${streamIndex}" class="form-label">Video Name (e.g., rain.mp4)</label>
                <input type="text" class="form-control" id="videoname${streamIndex}" name="streams[${streamIndex}][videoname]" required>
            </div>
        `;
        document.getElementById('streams').insertAdjacentHTML('beforeend', html);
        streamIndex++;
    }
</script>

</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Streaming App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Live Streaming App</h1>
    <form id="streamForm" method="POST" action="{{ route('startStream') }}">
        @csrf
        <div class="mb-3">
            <label for="streamKey" class="form-label">Stream Key</label>
            <input type="text" class="form-control" id="streamKey" name="streamKey" required>
        </div>
        <div class="mb-3">
            <label for="videoname" class="form-label">Video Name (e.g., rain.mp4)</label>
            <input type="text" class="form-control" id="videoname" name="videoname" required>
        </div>
        <button type="submit" class="btn btn-primary">Start Stream</button>
    </form>
</div>
</body>
</html> -->
