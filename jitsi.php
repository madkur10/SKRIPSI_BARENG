<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
    </head>
    <body>
        <script src="https://meet.jit.si/external_api.js"></script>
        <script>
            var domain = "meet.jit.si";
            var options = {
                roomName: "<?=$_GET['uuid']?>",
                width: 700,
                height: 700,
                parentNode: undefined,
                configOverwrite: {},
                interfaceConfigOverwrite: {}
            }
            var api = new JitsiMeetExternalAPI(domain, options);
        </script>
    </body>
</html>