package com.pidev.gui.travail.user;

import com.codename1.components.ImageViewer;
import com.codename1.ui.*;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.UIManager;
import com.codename1.ui.util.Resources;
import com.pidev.MainApp;
import com.pidev.entities.User;
import com.pidev.utils.Statics;

import java.text.SimpleDateFormat;

public class MyProfile extends Form {


    Resources theme = UIManager.initFirstTheme("/theme");

    public static User currentUser = null;
    Button editProfileBtn;

    public MyProfile(Form previous) {
        super("Mon profil", new BoxLayout(BoxLayout.Y_AXIS));

        addGUIs();
        addActions();

        super.getToolbar().addMaterialCommandToLeftBar("  ", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    }

    public void refresh() {
        this.removeAll();
        addGUIs();
        addActions();
        this.refreshTheme();
    }

    private void addGUIs() {

        currentUser = MainApp.getSession();

        editProfileBtn = new Button("Modifier mon profil");
        editProfileBtn.setUIID("buttonWhiteCenter");

        this.add(editProfileBtn);

        this.add(makeUserModel(currentUser));
    }

    private void addActions() {
        editProfileBtn.addActionListener(action -> {
            currentUser = null;
            new EditProfile(this).show();
        });
    }

    Label emailLabel, rolesLabel, passwordLabel, nomLabel, prenomLabel, villeLabel, dateNaissanceLabel, imageLabel;

    ImageViewer imageIV;


    private Component makeUserModel(User user) {
        Container userModel = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        userModel.setUIID("containerRounded");


        emailLabel = new Label("Email : " + user.getEmail());
        emailLabel.setUIID("labelDefault");

        rolesLabel = new Label("Roles : " + user.getRoles());
        rolesLabel.setUIID("labelDefault");

        passwordLabel = new Label("Password : " + user.getPassword());
        passwordLabel.setUIID("labelDefault");

        nomLabel = new Label("Nom : " + user.getNom());
        nomLabel.setUIID("labelDefault");

        prenomLabel = new Label("Prenom : " + user.getPrenom());
        prenomLabel.setUIID("labelDefault");

        villeLabel = new Label("Ville : " + user.getVille());
        villeLabel.setUIID("labelDefault");

        dateNaissanceLabel = new Label("DateNaissance : " + new SimpleDateFormat("dd-MM-yyyy").format(user.getDateNaissance()));
        dateNaissanceLabel.setUIID("labelDefault");

        imageLabel = new Label("Image : " + user.getImage());
        imageLabel.setUIID("labelDefault");

        if (user.getImage() != null) {
            String url = Statics.USER_IMAGE_URL + user.getImage();
            Image image = URLImage.createToStorage(
                    EncodedImage.createFromImage(theme.getImage("default.jpg").fill(1100, 500), false),
                    url,
                    url,
                    URLImage.RESIZE_SCALE
            );
            imageIV = new ImageViewer(image);
        } else {
            imageIV = new ImageViewer(theme.getImage("default.jpg").fill(1100, 500));
        }
        imageIV.setFocusable(false);

        userModel.addAll(
                emailLabel, rolesLabel, passwordLabel, nomLabel, prenomLabel, villeLabel, dateNaissanceLabel, imageLabel

                , imageIV

        );

        return userModel;
    }
}