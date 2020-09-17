<?php $request = app('Illuminate\Http\Request'); ?>


<?php $__env->startSection('content'); ?>
    
    <h3 class="page-title"> Lotes </h3>
    

    

    <div class="panel panel-default">
        <div class="panel-heading">
            
            Lista

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sub_catogory_create')): ?>



                <a href="<?php echo e(URL_SUB_CATEGORIES_ADD); ?>" class="btn btn-success btn-add pull-right">
                    Agregar
                </a>
                <a href="<?php echo e(URL_LIST_AUCTIONS); ?>" class="btn btn-info btn-add pull-right">Subastas</a>
            <?php endif; ?>

        </div>

        <div class="panel-body table-responsive">


            <table class="table table-bordered table-striped datatable">

                <thead>
                    <tr>
                        <th style="text-align:center;">No.</th>

                       

                        <th>Lotes</th>
                        

                        <th>Empresas</th>


                        <th>Estados</th>

                       
                        <th>&nbsp;Acciones</th>
                        
                    </tr>
                </thead>

            <?php if(count($sub_categories) > 0): ?>
                <tbody>
                    <?php if(count($sub_categories) > 0): ?>
                     <?php $i=0;?>
                        <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php $i++;?>
                            <tr data-entry-id="<?php echo e($category->id); ?>">

                               <td style="text-align:center;"><?php echo e($i); ?></td>

                                <td field-key='description'><?php echo $category->sub_category; ?></td>

                                <td field-key='category'><?php echo e($category->category); ?></td>

                                <td field-key='status'><?php echo e($category->status); ?></td>

                                
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_view')): ?>

                                        <a href="<?php echo e(URL_SUB_CATEGORIES_VIEW); ?>/<?php echo e($category->slug); ?> " class="btn btn-xs btn-primary"> Ver </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_edit')): ?>

                                        <a href="<?php echo e(URL_SUB_CATEGORIES_EDIT); ?>/<?php echo e($category->slug); ?>" class="btn btn-xs btn-info">Editar</a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_delete')): ?>

                                        <a class="btn btn-xs btn-danger" href="javascript:void(0)" onclick="deleteRecord('<?php echo e($category->id); ?>')"> Eliminar</a>

                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_invitacion')): ?>
                                        <a href="<?php echo e(URL_AUCTIONS_Invitaciones); ?>/<?php echo e($category->slug); ?>" class="btn btn-xs btn-info"> Invitaciones</a>
                                    <?php endif; ?>

                                </td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            
                            <td colspan="7"> no hay entradas en la tabla </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                 <?php endif; ?>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?> 

 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_delete')): ?> 
        <?php echo $__env->make('common.deletescript', array('route'=>URL_SUB_CATEGORIES_DELETE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>

    

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>