<?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['tag' => 'button','icon' => 'heroicon-o-arrow-down-tray','label' => 'Exportar XLSX','color' => 'gray','size' => 'md','xData' => '{
        doExport() {
            const resource = \''.e(request()->segment(2)).'\'
            const searchInput = this.$el.closest(\'.fi-ta-header-toolbar\')?.querySelector(\'.fi-ta-search-field input\')
            const search = searchInput?.value ?? \'\'

            const params = new URLSearchParams({ resource, search })

            window.open(\'/admin/export?\' + params.toString(), \'_blank\')
        }
    }','xOn:click' => 'doExport()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'button','icon' => 'heroicon-o-arrow-down-tray','label' => 'Exportar XLSX','color' => 'gray','size' => 'md','x-data' => '{
        doExport() {
            const resource = \''.e(request()->segment(2)).'\'
            const searchInput = this.$el.closest(\'.fi-ta-header-toolbar\')?.querySelector(\'.fi-ta-search-field input\')
            const search = searchInput?.value ?? \'\'

            const params = new URLSearchParams({ resource, search })

            window.open(\'/admin/export?\' + params.toString(), \'_blank\')
        }
    }','x-on:click' => 'doExport()']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $attributes = $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $component = $__componentOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php /**PATH /var/www/Pessoal/brokerages/resources/views/filament/tables/export-button.blade.php ENDPATH**/ ?>