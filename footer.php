</div>
        <div class="sidebar">
            <div class="widget">
                <div class="widget-header">Контакты</div>
                <div class="widget-body">
                    <img src="images/карта.jpg" alt="">
                </div>
            </div>
        </div>
    </main>
    <img src="images/bg.jpg" class="bg_img">
    <script>
        function showPass (el) {
            if (el.previousElementSibling.attributes[0].value == "password") {
                el.previousElementSibling.attributes[0].value = 'text';
            } else el.previousElementSibling.attributes[0].value = 'password';
            
            console.log(el.previ)
        }
    
    </script>
</body>
</html>