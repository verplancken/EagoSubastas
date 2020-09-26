<?php $__env->startSection('content'); ?>
    <h3 class="page-title"><?php echo e(getPhrase('users')); ?></h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo e($title); ?>

        </div>

        <div class="panel-body table-responsive">
            <div class="row">

                <div class="col-md-6">

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th> <?php echo e(getPhrase('name')); ?> </th>
                            <td field-key='name'><?php echo e($user->name); ?></td>
                        </tr>

                        <tr>
                            <th> <?php echo e(getPhrase('username')); ?> </th>
                            <td field-key='name'><?php echo e($user->username); ?></td>
                        </tr>


                        <tr>
                            <th> <?php echo e(getPhrase('email')); ?> </th>
                            <td field-key='email'><?php echo e($user->email); ?></td>
                        </tr>


                        <tr>
                            <th><?php echo app('translator')->getFromJson('global.users.fields.role'); ?></th>
                            <td field-key='role'>
                               <?php echo e($user->display_name); ?>

                            </td>
                        </tr>

                         <tr>
                            <th> <?php echo e(getPhrase('phone')); ?> </th>
                            <td field-key='phone'><?php echo e($user->phone); ?></td>
                        </tr>

                         <tr>
                            <th> <?php echo e(getPhrase('status')); ?> </th>
                            <td field-key='status'>
                                <?php if($user->approved==1): ?>
                                Aprovado
                                <?php elseif($user->approved==0): ?>
                                Bloqueado
                                <?php endif; ?>
                            </td>
                        </tr>
                       
                    </table>

                </div>



                <div class="col-md-6">

                    <table class="table table-bordered table-striped">
                        
                        <tr>
                            <th> <?php echo e(getPhrase('country')); ?> </th>
                            <td field-key='country'><?php echo e($user->title); ?></td>
                        </tr>

                        <tr>
                            <th> <?php echo e(getPhrase('state')); ?> </th>
                            <td field-key='state'><?php echo e($user->state); ?></td>
                        </tr>

                        <tr>
                            <th> <?php echo e(getPhrase('city')); ?> </th>
                            <td field-key='city'><?php echo e($user->city); ?></td>
                        </tr>

                        <tr>
                            <th> <?php echo e(getPhrase('address')); ?> </th>
                            <td field-key='address'><?php echo e($user->address); ?></td>
                        </tr>

                        <tr>
                            <th> <?php echo e(getPhrase('image')); ?> </th>
                        <td field-key='image'>  <img src="<?php echo e(getProfilePath($user->image)); ?>" /> </td>
                        </tr>
                        
                        <?php if($user->role_id==getRoleData('seller')): ?>
                        <tr>
                            <th> <?php echo e(getPhrase('company_logo')); ?> </th>
                        <td field-key='company_logo'>  <img src="<?php echo e(getCompanyLogo($user->company_logo)); ?>" /> </td>
                        </tr>
                        <?php endif; ?>
                       
                    </table>

                </div>

            </div>









            <p>&nbsp;</p>

            <a href="<?php echo e(URL_USERS); ?>" class="btn btn-default"><?php echo app('translator')->getFromJson('global.app_back_to_list'); ?></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>