<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


    <div class="flex items-center gap-2 border-b border-outline-variant px-5 py-4">

        <span class="material-symbols-outlined text-primary">
            shopping_cart
        </span>

        <p class="font-bold text-on-surface">
            Current PO Draft
        </p>

    </div>


    <div class="p-5">

        <div data-ajax-cart-flash>

            <?php if($errors->has('draft')): ?>

                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700">
                    <?php echo e($errors->first('draft')); ?>

                </div>

            <?php endif; ?>


            <?php if(session('success')): ?>

                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs text-green-700">
                    <?php echo e(session('success')); ?>

                </div>

            <?php endif; ?>

        </div>


        <!-- SUPPLIER FORM -->

        <form
            method="POST"
            action="<?php echo e(route('procurement.draft.set-supplier')); ?>"
            id="draft-supplier-form"
            class="mb-5 space-y-3"
            data-ajax-cart
            data-no-loading
        >

            <?php echo csrf_field(); ?>


            <div>

                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                    Select Supplier
                </label>


                <select
                    name="fk_supplier"
                    onchange="document.getElementById('draft-supplier-form').requestSubmit()"
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >

                    <option value="">
                        -- Pilih Supplier --
                    </option>


                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option
                            value="<?php echo e($supplier->id_master_supplier); ?>"
                            <?php echo e($cartSupplier?->id_master_supplier === $supplier->id_master_supplier ? 'selected' : ''); ?>

                        >
                            <?php echo e($supplier->nm_master_supplier); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>

            </div>


            <div>

                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                    Deskripsi / Alasan (opsional)
                </label>


                <input
                    type="text"
                    name="desc_po"
                    maxlength="100"
                    value="<?php echo e($cart['desc_po'] ?? ''); ?>"
                    onchange="document.getElementById('draft-supplier-form').requestSubmit()"
                    placeholder="Contoh: Restock kebutuhan proyek Line 3"
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >

            </div>

        </form>


        <p class="mb-2 text-xs font-bold uppercase tracking-wide text-on-surface-variant">
            Items (<?php echo e($cartItems->count()); ?>)
        </p>


        <?php if($cartItems->isEmpty()): ?>

            <div class="flex flex-col items-center rounded-lg border border-dashed border-outline-variant py-10 text-center">

                <span class="material-symbols-outlined text-[32px] text-outline-variant">
                    shopping_cart
                </span>

                <p class="mt-2 px-4 text-xs text-on-surface-variant">
                    Add items from the critical stock list to build your purchase order.
                </p>

            </div>

        <?php else: ?>

            <div class="space-y-2">

                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="rounded-lg border border-outline-variant p-3">

                        <div class="mb-2 flex items-start justify-between gap-2">

                            <div class="min-w-0">

                                <p class="truncate text-xs font-bold text-on-surface">
                                    <?php echo e($item->barang->kd_master_barang); ?>

                                </p>

                                <p class="truncate text-sm text-on-surface-variant">
                                    <?php echo e($item->barang->nm_master_barang); ?>

                                </p>

                            </div>


                            <form
                                method="POST"
                                action="<?php echo e(route('procurement.draft.remove-item', $item->barang)); ?>"
                                data-ajax-cart
                                data-no-loading
                            >

                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>


                                <button
                                    type="submit"
                                    class="text-outline transition hover:text-error"
                                    title="Hapus"
                                >

                                    <span class="material-symbols-outlined text-[18px]">
                                        close
                                    </span>

                                </button>

                            </form>

                        </div>


                        <form
                            method="POST"
                            action="<?php echo e(route('procurement.draft.update-item', $item->barang)); ?>"
                            class="flex items-center gap-2"
                            data-ajax-cart
                            data-no-loading
                        >

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>


                            <span class="text-xs text-on-surface-variant">
                                Qty:
                            </span>


                            <div class="flex items-center rounded-md border border-outline-variant">

                                <button
                                    type="button"
                                    onclick="this.nextElementSibling.stepDown(); this.closest('form').requestSubmit();"
                                    class="px-2 py-1 text-on-surface-variant hover:text-primary"
                                >
                                    -
                                </button>


                                <input
                                    type="number"
                                    name="qty"
                                    value="<?php echo e($item->qty); ?>"
                                    min="1"
                                    onchange="this.closest('form').requestSubmit()"
                                    class="w-14 border-none bg-transparent px-1 py-1 text-center text-sm focus:ring-0"
                                >


                                <button
                                    type="button"
                                    onclick="this.previousElementSibling.stepUp(); this.closest('form').requestSubmit();"
                                    class="px-2 py-1 text-on-surface-variant hover:text-primary"
                                >
                                    +
                                </button>

                            </div>

                        </form>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        <?php endif; ?>

    </div>


    <div class="border-t border-outline-variant p-5">

        <div class="mb-3 flex items-center justify-between text-sm">

            <span class="text-on-surface-variant">
                Total Items:
            </span>

            <span class="font-bold text-on-surface">
                <?php echo e($cartItems->count()); ?>

            </span>

        </div>


        <form
            method="POST"
            action="<?php echo e(route('procurement.draft.create')); ?>"
        >

            <?php echo csrf_field(); ?>


            <button
                type="submit"
                <?php echo e($cartItems->isEmpty() ? 'disabled' : ''); ?>

                class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
            >

                <span class="material-symbols-outlined text-[18px]">
                    send
                </span>

                Create Purchase Order

            </button>

        </form>

    </div>

</div><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/procurement/partials/draft-panel.blade.php ENDPATH**/ ?>