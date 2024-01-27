@extends('layouts.admin')

@section('contentheader')
    Repport
@endsection

@section('content')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <form>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_from_orders">Date From</label>
                                        <input type="text" class="form-control" id="date_from_orders" name="date_from_orders" placeholder="YYYY/MM/DD" value="{{ $date_from }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_to_orders">Date To</label>
                                        <input type="text" class="form-control" id="date_to_orders" name="date_to_orders" placeholder="YYYY/MM/DD" value="{{ $date_to }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="orderid">Order ID</label>
                                        <input type="number" min="1" class="form-control" id="order_id" name="order_id" placeholder="Order ID">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php
                                        $status_array = array(
                                            "wc-pending",
                                            "wc-processing",
                                            "wc-on-hold",
                                            "wc-was-shipped"
                                        );
                                        ?>
                                        <select class="form-control" name="order_status">
                                            <option value="wc-pending">بانتظار الدفع</option>
                                            <option value="wc-processing">مؤكد</option>
                                            <option value="wc-on-hold">بانتظار الحوالة البنكية</option>
                                            <option value="wc-was-shipped">تم الشحن</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <table id="orderTable" class="table table-bordered table-striped table-sm display nowrap" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">رقم الطلب</th>
                                    <th scope="col">رقم الفاتورة</th>
                                    <th scope="col">اسم العميل</th>
                                    <th scope="col">رقم الهاتف</th>
                                    <th scope="col">تاريخ التعديل</th>
                                    <th scope="col">تاريخ الطلب</th>
                                    <th scope="col">الدولة</th>
                                    <th scope="col">العنوان</th>
                                    <th scope="col">المدينة</th>
                                    <th scope="col">الحالة</th>
                                    <th scope="col">وسيلة الدفع</th>
                                    <th scope="col">الرقم الضريبي</th>
                                    <th scope="col">المحفظة / خصم</th>
                                    <th scope="col">القسيمة</th>
                                    <th scope="col">المنتجات</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">التصنيفات</th>
                                    <th scope="col">مسمى الحجم</th>
                                    <th scope="col">الأحجام</th>
                                    <th scope="col">الكمية</th>
                                    <th scope="col">السعر</th>
                                    <th scope="col">المجموع</th>
                                    <th scope="col">خصم القسيمة</th>
                                    <th scope="col">الشحن</th>
                                    <th scope="col">القيمة المضافة</th>
                                    <th scope="col">الإجمالي</th>
                                    <th scope="col">ملاحظات العميل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key=>$order)
                                <?php
                                $order_postmeta = DB::table('wp_postmeta')->where('post_id', $order->ID)->get();
                                ?>
                                <?php
                                $invoice_number = "";
                                $customer_name = "";
                                $phone = "";
                                $status_changed_at = "";
                                $country = "";
                                $address = "";
                                $city = "";
                                $payment_method = "";
                                $company_vat = "";
                                $shipping_amount = "";
                                $order_total = "";
                                $order_date = "";
                                $order_status = "";
                                foreach ($order_postmeta as $ord_postmeta) {
                                    foreach ($ord_postmeta as $index => $data) {
                                        if ($index === 'meta_key' && $data === '_wcpdf_invoice_number') {
                                            $invoice_number = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_billing_first_name') {
                                            $customer_name = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_billing_last_name') {
                                            $customer_name .= " " . $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_billing_phone') {
                                            $phone = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_order_status_change') {
                                            $status_changed_at = date("d/m/Y", $ord_postmeta->meta_value);
                                        }
                                        if ($index === 'meta_key' && $data === '_billing_country') {
                                            $country = $ord_postmeta->meta_value;
                                            $country_data = DB::table('country')->where('id', $country)->first();
                                            $country = $country_data->name;
                                        }
                                        if ($index === 'meta_key' && $data === '_billing_address_1') {
                                            $address = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_billing_city') {
                                            $city = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_payment_method_title') {
                                            $payment_method = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_billing_billing_company_vat') {
                                            $company_vat = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_order_shipping') {
                                            $shipping_amount = $ord_postmeta->meta_value;
                                        }
                                        if ($index === 'meta_key' && $data === '_order_total') {
                                            $order_total = $ord_postmeta->meta_value;
                                        }
                                    }
                                }
                                $order_date = date("d/m/Y", strtotime($order->post_date));
                                ?>
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $order->ID }}</td>
                                    <td>{{ $invoice_number }}</td>
                                    <td>{{ $customer_name }}</td>
                                    <td>{{ $phone }}</td>
                                    <td>{{ $status_changed_at }}</td>
                                    <td>{{ $order_date }}</td>
                                    <td>{{ $country }}</td>
                                    <td>{{ $address }}</td>
                                    <td>{{ $city }}</td>
                                    <?php
                                    $status = substr($order->post_status, 3);
                                    $post_status = DB::table('wp_posts')->where('post_name', $status)->first();
                                    ?>
                                    <td>{{ $post_status->post_title }}</td>
                                    <td>{{ $payment_method }}</td>
                                    <td>{{ $company_vat }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ number_format((float) $shipping_amount, 2, '.', ' ') }}</td>
                                    <td></td>
                                    <td>{{ number_format((float) $order_total, 2, '.', ' ') }}</td>
                                    <td></td>
                                </tr>
                                <?php
                                $list_products = DB::table('wp_woocommerce_order_items')
                                    ->where([
                                        ['order_id', $order->ID],
                                        ['order_item_type', 'line_item']
                                    ])
                                    ->get();
                                foreach ($list_products as $order_item) {
                                ?>
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $order->ID }}</td>
                                        <td>{{ $invoice_number }}</td>
                                        <td>{{ $customer_name }}</td>
                                        <td>{{ $phone }}</td>
                                        <td>{{ $status_changed_at }}</td>
                                        <td>{{ $order_date }}</td>
                                        <td>{{ $country }}</td>
                                        <td></td>
                                        <td></td>
                                        <?php
                                        $status = substr($order->post_status, 3);
                                        $post_status = DB::table('wp_posts')->where('post_name', $status)->first();
                                        ?>
                                        <td>{{ $post_status->post_title }}</td>
                                        <td>{{ $payment_method }}</td>
                                        <td>{{ $company_vat }}</td>
                                        <td></td>
                                        <?php
                                        $order_item_data = DB::table('wp_woocommerce_order_itemmeta')
                                            ->where('order_item_id', $order_item->order_item_id)
                                            ->get();
                                        $list_coupons = DB::table('wp_woocommerce_order_items')
                                            ->where([
                                                ['order_id', $order->ID],
                                                ['order_item_type', 'coupon']
                                            ])
                                            ->get();
                                        $item_size = "";
                                        $item_qty = "";
                                        $item_sku = "";
                                        $item_line_subtotal = "";
                                        $item_line_total = "";
                                        $item_line_tax = "";
                                        $coupons = "";
                                        $cumCoupons = count($list_coupons);
                                        $i = 0;
                                        foreach ($list_coupons as $index => $coupon) {
                                            $coupons .= $coupon->order_item_name;
                                            if ((++$i !== $cumCoupons) && ($cumCoupons > 1)) {
                                                $coupons .= ", ";
                                            }
                                        }
                                        foreach ($order_item_data as $ord_item_data) {
                                            foreach ($ord_item_data as $index => $data) {
                                                if ($index === 'meta_key' && $data === 'pa_الحجم') {
                                                    $item_size = $ord_item_data->meta_value;
                                                }
                                                if ($index === 'meta_key' && $data === '_qty') {
                                                    $item_qty = $ord_item_data->meta_value;
                                                }
                                                if ($index === 'meta_key' && $data === '_sku') {
                                                    $item_sku = $ord_item_data->meta_value;
                                                }
                                                if ($index === 'meta_key' && $data === '_line_subtotal') {
                                                    $item_line_subtotal = $ord_item_data->meta_value;
                                                    $item_line_subtotal = $item_line_subtotal / $item_qty;
                                                }
                                                if ($index === 'meta_key' && $data === '_line_total') {
                                                    $item_line_total = $ord_item_data->meta_value;
                                                }
                                                if ($index === 'meta_key' && $data === '_line_tax') {
                                                    $item_tax = $ord_item_data->meta_value;
                                                }
                                                if ($index === 'meta_key' && $data === '_line_tax') {
                                                    $item_line_tax = $ord_item_data->meta_value;
                                                }
                                            }
                                        }
                                        ?>
                                        <td>{{ $coupons }}</td>
                                        <td>{{ $order_item->order_item_name }}</td>
                                        <td>{{ $item_sku }}</td>
                                        <td></td>
                                        <td>{{ $item_size }}</td>
                                        <td></td>
                                        <td>{{ $item_qty }}</td>
                                        <td>{{ number_format((float) $item_line_subtotal, 4, '.', '') }}</td>
                                        <td>{{ number_format((float) $item_line_total, 4, '.', '') }}</td>
                                        <?php
                                            $item_discount = 0;
                                            $item_discount = $item_qty * $item_line_subtotal - $item_line_total;
                                        ?>
                                        <td>{{ number_format((float) $item_discount, 4, '.', '') }}</td>
                                        <td></td>
                                        <td>{{ number_format((float) $item_line_tax, 4, '.', '') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div>
</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('scripts')

<script>
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var status = urlParams.get('order_status');
    $('select[name=order_status]').val(status);

    $.fn.DataTable.ext.pager.numbers_length = 4;

    document.addEventListener('DOMContentLoaded', function() {

        $("#orderTable").DataTable({
            "ordering": false,
            "lengthChange": true,
            "autoWidth": true,
            "scrollX": true,
            // "paging": false,
            // "scrollCollapse": true,
            // "scrollX": true,
            // "scrollY": 500,
            "select": {
                style: 'multi',
                selector: 'td:first-child'
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            // "buttons": [{
            //         extend: 'excel',
            //         text: 'Excel',
            //         className: 'buttons-export',
            //         filename: function() {
            //             var date = moment();
            //             var currentDate = date.format('D-MM-YYYY');
            //             return 'Export-' + currentDate;
            //         },
            //         exportOptions: {
            //             columns: ':visible:Not(.not-exported)',
            //             rows: {
            //                 selected: true
            //             }
            //         },
            //     },
            //     {
            //         extend: 'colvis',
            //         text: 'Column visibility',
            //         //columns: ':not(.noVis)'
            //         columns: ':gt(0)'
            //     },
            // ]





            "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#orderTable_wrapper .col-md-6:eq(0)');

    }, false);

    $(document).ready(function() {

    });
</script>
@endsection

@section('scripts')
    <script>
        $(".active").removeClass("active");
        $("#orders-item").addClass("active");
    </script>
@endsection