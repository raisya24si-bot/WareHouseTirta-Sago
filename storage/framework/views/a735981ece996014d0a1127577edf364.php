<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <div class="flex items-center justify-between border-b border-outline-variant px-5 py-4">

        <p class="font-bold text-on-surface">
            Critical Stock Action List
        </p>

    </div>


    <div class="overflow-x-auto custom-scrollbar">

        <table class="w-full min-w-[720px] text-left text-sm">

            <thead class="border-b border-outline-variant bg-surface-container-low">

                <tr>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Item Code
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Name
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Current Stock
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Minimal Stock
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Recommended Order
                    </th>

                    <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                        Action
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-outline-variant/60">

                <?php $__empty_1 = true; $__currentLoopData = $criticalItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php

                        /*
                        |--------------------------------------------------------------------------
                        | BARANG ID
                        |--------------------------------------------------------------------------
                        */

                        $barangId =
                            $row->barang->id_master_barang;


                        /*
                        |--------------------------------------------------------------------------
                        | CEK CURRENT PO DRAFT
                        |--------------------------------------------------------------------------
                        */

                        $alreadyInCart =
                            $cartItems->contains(
                                fn ($c) =>
                                    $c->barang->id_master_barang ===
                                    $barangId
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | CEK PO YANG SUDAH ADA
                        |--------------------------------------------------------------------------
                        |
                        | Kalau barang sudah masuk PO aktif,
                        | ambil nomor PO-nya.
                        |
                        */

                        $existingPoNumber =
                            $poPerBarang[$barangId]
                            ?? null;

                    ?>


                    <tr class="transition hover:bg-surface-container-low/60">

                        <td class="px-4 py-3 font-medium text-primary">
                            <?php echo e($row->barang->kd_master_barang); ?>

                        </td>


                        <td class="px-4 py-3">
                            <?php echo e($row->barang->nm_master_barang); ?>

                        </td>


                        <td class="px-4 py-3">

                            <span
                                class="rounded-full px-2.5 py-1 text-xs font-bold
                                <?php echo e($row->current_stock <= 0
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-amber-100 text-amber-700'); ?>"
                            >

                                <?php echo e($row->current_stock); ?> unit

                            </span>

                        </td>


                        <td class="px-4 py-3 text-on-surface-variant">
                            <?php echo e($row->minimum_stock); ?> unit
                        </td>


                        <td class="px-4 py-3 font-medium">
                            <?php echo e($row->recommended_order); ?> unit
                        </td>


                        <!-- ================================================= -->
                        <!-- ACTION -->
                        <!-- ================================================= -->

                        <td class="px-4 py-3 text-right">

                            <?php if($existingPoNumber): ?>

                                
                                
                                

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700"
                                    title="Barang sudah masuk ke Purchase Order"
                                >

                                    <span class="material-symbols-outlined text-[16px]">
                                        check_circle
                                    </span>

                                    <?php echo e($existingPoNumber); ?>


                                </span>


                            <?php elseif($alreadyInCart): ?>

                                
                                
                                

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-md bg-primary/10 px-3 py-1.5 text-xs font-medium text-primary"
                                    title="Barang sudah ditambahkan ke draft PO"
                                >

                                    <span class="material-symbols-outlined text-[16px]">
                                        check
                                    </span>

                                    Added

                                </span>


                            <?php else: ?>

                                
                                
                                

                                <form
                                    method="POST"
                                    action="<?php echo e(route('procurement.draft.add-item')); ?>"
                                    data-ajax-cart
                                    data-no-loading
                                >

                                    <?php echo csrf_field(); ?>

                                    <input
                                        type="hidden"
                                        name="fk_barang"
                                        value="<?php echo e($row->barang->id_master_barang); ?>"
                                    >


                                    <input
                                        type="hidden"
                                        name="qty"
                                        value="<?php echo e($row->recommended_order > 0 ? $row->recommended_order : 1); ?>"
                                    >


                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-md border border-primary/30 bg-primary/5 px-3 py-1.5 text-xs font-medium text-primary transition hover:bg-primary/10"
                                    >

                                        <span class="material-symbols-outlined text-[16px]">
                                            add_shopping_cart
                                        </span>

                                        Add to PO

                                    </button>

                                </form>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="6"
                            class="px-4 py-12 text-center text-on-surface-variant"
                        >
                            Semua stok barang aman, nggak ada yang di bawah minimal stock. 🎉
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/procurement/partials/critical-stock.blade.php ENDPATH**/ ?>