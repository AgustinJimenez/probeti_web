<script id="tabla-detalles-template" type="text/x-handlebars-template">
    <?php $table_detalles_columns = 
    [
        "Tipos",
        "Retiradas",
        "Ensayadas",
        "Facturadas"
        /*
        "Por Cobrar",
        "Por Ensayar"
        */
    ];
    ?>
    <div class="table-responsive">
        <table class="data-table table table-bordered table-hover table-condensed">
            <thead class="blue-bg">
                @foreach ($table_detalles_columns as $column)
                    <th class="bg-primary text-center">{{ $column }}</th>
                @endforeach
            </thead>
            <tbody>
                <tr class="chicas">
                    <td class="text-center bg-primary">
                        <b>Chicas</b>
                    </td>

                    <td class="retiradas probeta"> 
                        <?="{{datos_probetas.retiradas.chicas}}";?> 
                    </td>
                    <td class="ensayadas  probeta"> 
                        <?="{{datos_probetas.ensayadas.chicas}}";?> 
                    </td>
                    <td class="facturadas  probeta"> 
                        <?="{{datos_probetas.facturadas.chicas}}";?> 
                    </td>
                    <!--
                    <td class="por_cobrar  probeta"> 
                        <?="{{datos_probetas.por_cobrar.chicas}}";?> 
                    </td>
                    <td class="por_ensayar  probeta"> 
                        <?="{{datos_probetas.por_ensayar.chicas}}";?> 
                    </td>
                    -->
                </tr>
                <tr class="medianas">
                    <td class="text-center bg-primary">
                        <b>Medianas</b>
                    </td>
                    <td class="retiradas probeta"> 
                        <?="{{datos_probetas.retiradas.medianas}}";?> 
                    </td>
                    <td class="ensayadas probeta">
                        <?="{{datos_probetas.ensayadas.medianas}}";?> 
                    </td>
                    <td class="facturadas probeta">
                         <?="{{datos_probetas.facturadas.medianas}}";?> 
                    </td>
                    <!--
                    <td class="por_cobrar probeta">
                         <?="{{datos_probetas.por_cobrar.medianas}}";?>
                    </td>
                    <td class="por_ensayar probeta">
                        <?="{{datos_probetas.por_ensayar.medianas}}";?> 
                    </td>
                    -->
                </tr>
                <tr class="grandes">
                    <td class="text-center bg-primary">
                        <b>Grandes</b>
                    </td>
                    <td class="retiradas probeta"> 
                        <?="{{datos_probetas.retiradas.grandes}}";?>
                    </td>
                    <td class="ensayadas probeta"> 
                        <?="{{datos_probetas.ensayadas.grandes}}";?> 
                    </td>
                    <td class="facturadas probeta"> 
                        <?="{{datos_probetas.facturadas.grandes}}";?> 
                    </td>
                    <!--
                    <td class="por_cobrar probeta"> 
                        <?="{{datos_probetas.por_cobrar.grandes}}";?> 
                    </td>
                    <td class="por_ensayar probeta"> 
                        <?="{{datos_probetas.por_ensayar.grandes}}";?> 
                    </td>
                    -->
                </tr>
                <tfoot class="todas bg-primary">
                    <tr>
                        <td class="text-center">
                            <b>TOTAL</b>
                        </td>
                        <td class="retiradas todas-retiradas">
                            <b> <?="{{datos_probetas.total_retiradas}}";?> </b>
                        </td>
                        <td class="ensayadas todas-ensayadas">
                            <b><?="{{datos_probetas.total_ensayadas}}";?></b>
                        </td>
                        <td class="facturadas todas-facturadas">
                            <b><?="{{datos_probetas.total_facturadas}}";?></b>
                        </td>
                        <!--
                        <td class="por_cobrar todas-por_cobrar">
                            <b> <?="{{datos_probetas.total_por_cobrar}}";?> </b>
                        </td>
                        <td class="por_ensayar todas-por_ensayar">
                            <b> <?="{{datos_probetas.total_por_ensayar}}";?> </b>
                        </td>
                        -->
                    </tr>
                </tfoot>
            </tbody>
        </table>
        <hr>
    </div>
</script>