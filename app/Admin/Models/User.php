<?php

use App\Models\User;
use App\Models\Image;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    $model->setTitle('Пользователи');
    
    $model->onDisplay(function () {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
//            ->setColumnFilters([
//                AdminColumnFilter::text()->setPlaceholder('Full Name'),
//                null,
//                null,
//                null,
//                null,
//                null,
//                null,
//            ])
            ->setColumns([
                AdminColumn::link('firstname')->setLabel('Имя'),
                AdminColumn::link('surname')->setLabel('Фамилия'),
                AdminColumn::email('email')->setLabel('Email'),
                AdminColumn::text('phone')->setLabel('Телефон'),
                AdminColumnEditable::checkbox('is_admin')->setLabel('Администратор'),
                AdminColumnEditable::checkbox('confirmed')->setLabel('Статус'),
                AdminColumn::datetime('created_at')->setLabel('Дата регистрации'),
            ])
            ->paginate(20);
    });
    
    $model->onCreateAndEdit(function($id = null) {
        $form =  AdminForm::panel()->addBody([
            AdminFormElement::text('firstname', 'Имя')->required(),
            AdminFormElement::text('surname', 'Фамилия')->required(),
            AdminFormElement::text('email', 'E-mail')->required()->addValidationRule('email'),
            AdminFormElement::checkbox('is_admin', 'Администратор')->addValidationRule('boolean'),
            AdminFormElement::checkbox('confirmed', 'Активирован')->addValidationRule('boolean'),
        ]);
        $form->getButtons()
            ->setSaveButtonText('Сохранить пользователя');

        if (!is_null($id)) { // Если галерея создана и у нее есть ID
            $photos = AdminDisplay::table()
                ->setModelClass(Image::class)
                ->setApply(function($query) use($id) {
                    $query->where('item_id', $id)->where('module', 'User');
                })
                ->setParameter('item_id', $id)
                ->setColumns([
                    AdminColumn::link('file', 'Название фотографии'),
                    AdminColumn::custom('Фотография', function($image) {
                        return "<a href='".url("/images/uploads/".strtolower($image->module)."/".$image->file)."' data-toggle='lightbox'><img class='thumbnail' width='80px' src='".url("/images/uploads/".strtolower($image->module)."/".$image->file)."'></a>";
                    }),
                ]);

        $form->addBody($photos);
        }
        return $form;

    });
});