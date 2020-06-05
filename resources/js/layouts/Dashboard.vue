<template>
<div>
    <topbar />
  <!-- Begin page -->
    <div class="container-fluid">
        <div class="wrapper">
            <sidebar />
        
            <div class="content-page">
                <div class="content">
                    <!-- Start Content-->
                    <div class="row top-start">
                        <div class="col-12">

                            <child/>
                        </div>
                    </div>
                    <!-- container -->
                </div>
                <!-- content -->
            </div>
        </div>
    </div>
    <!-- END wrapper -->
</div>
</template>

<script>
export default {
  name: 'Dashboard'
}
</script>

