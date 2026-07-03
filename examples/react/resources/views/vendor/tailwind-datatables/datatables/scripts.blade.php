{{--
    Bu dosya, JS-CONFIG BRIDGE ve Yajra DataTables'ın varsayılan scriptlerini yükler.
    window.GorlabsDatatables.config objesi, PHP config değerlerini JavaScript'e aktarır.
    crud-datatable.js ve post-form.js bu config değerlerini okur.
--}}
<script>
    // JS-CONFIG BRIDGE: PHP config değerlerini JavaScript'e aktar
    window.GorlabsDatatables = window.GorlabsDatatables || {};
    window.GorlabsDatatables.config = {!! json_encode($gorlabsDatatablesConfig ?? []) !!};
</script>
