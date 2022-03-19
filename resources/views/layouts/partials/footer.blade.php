<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <span>
                    كل الحقوق محفوظة لدى {{ get_setting('project_name') }}
                </span>
                © {{ date('Y', strtotime('-2 year')) }} - {{ date('Y') }}
            </div>
        </div>
    </div>
</footer>
