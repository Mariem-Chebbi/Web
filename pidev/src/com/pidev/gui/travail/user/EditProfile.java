package com.pidev.gui.travail.user;


import com.codename1.capture.Capture;
import com.codename1.components.ImageViewer;
import com.codename1.ui.*;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.UIManager;
import com.codename1.ui.util.Resources;
import com.pidev.MainApp;
import com.pidev.entities.User;
import com.pidev.services.UserService;
import com.pidev.utils.Statics;

import java.io.IOException;

public class EditProfile extends Form {


    Resources theme = UIManager.initFirstTheme("/theme");
    String selectedImage;
    boolean imageEdited = false;


    User currentUser;

    Label emailLabel, nomLabel, prenomLabel, villeLabel, dateNaissanceLabel, imageLabel;
    TextField
            emailTF,
            nomTF,
            prenomTF,
            villeTF,
            imageTF, elemTF;
    PickerComponent dateNaissanceTF;


    ImageViewer imageIV;
    Button selectImageButton;

    Button manageButton;

    Form previous;

    public EditProfile(Form previous) {
        super("Modifier mon profil", new BoxLayout(BoxLayout.Y_AXIS));
        this.previous = previous;


        addGUIs();
        addActions();

        getToolbar().addMaterialCommandToLeftBar("  ", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    }


    private void addGUIs() {
        currentUser = MainApp.getSession();


        emailLabel = new Label("Email : ");
        emailLabel.setUIID("labelDefault");
        emailTF = new TextField();
        emailTF.setHint("Tapez le email");


        nomLabel = new Label("Nom : ");
        nomLabel.setUIID("labelDefault");
        nomTF = new TextField();
        nomTF.setHint("Tapez le nom");

        prenomLabel = new Label("Prenom : ");
        prenomLabel.setUIID("labelDefault");
        prenomTF = new TextField();
        prenomTF.setHint("Tapez le prenom");

        villeLabel = new Label("Ville : ");
        villeLabel.setUIID("labelDefault");
        villeTF = new TextField();
        villeTF.setHint("Tapez le ville");
        dateNaissanceTF = PickerComponent.createDate(null).label("DateNaissance");


        imageLabel = new Label("Image : ");
        imageLabel.setUIID("labelDefault");
        selectImageButton = new Button("Ajouter une image");


        emailTF.setText(currentUser.getEmail());
        nomTF.setText(currentUser.getNom());
        prenomTF.setText(currentUser.getPrenom());
        villeTF.setText(currentUser.getVille());
        dateNaissanceTF.getPicker().setDate(currentUser.getDateNaissance());


        if (currentUser.getImage() != null) {
            selectedImage = currentUser.getImage();
            String url = Statics.USER_IMAGE_URL + currentUser.getImage();
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


        manageButton = new Button("Modifier");
        manageButton.setUIID("buttonWhiteCenter");

        Container container = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        container.setUIID("containerRounded");

        container.addAll(
                imageLabel, imageIV,
                selectImageButton,
                emailLabel, emailTF,
                nomLabel, nomTF,
                prenomLabel, prenomTF,
                villeLabel, villeTF,
                dateNaissanceTF,


                manageButton
        );

        this.addAll(container);
    }

    private void addActions() {

        selectImageButton.addActionListener(a -> {
            selectedImage = Capture.capturePhoto(900, -1);
            try {
                imageEdited = true;
                imageIV.setImage(Image.createImage(selectedImage));
            } catch (IOException e) {
                e.printStackTrace();
            }
            selectImageButton.setText("Modifier l'image");
        });

        manageButton.addActionListener(action -> {
            if (controleDeSaisie()) {
                int responseCode = UserService.getInstance().edit(
                        new User(
                                currentUser.getId(),
                                emailTF.getText(),
                                "ROLE_USER",
                                "",
                                nomTF.getText(),
                                prenomTF.getText(),
                                villeTF.getText(),
                                dateNaissanceTF.getPicker().getDate(),
                                selectedImage

                        ), imageEdited
                );
                if (responseCode == 200) {
                    Dialog.show("Succés", "Profil modifié avec succes", new Command("Ok"));
                    MainApp.setSession(new User(
                            currentUser.getId(),
                            emailTF.getText(),
                            "ROLE_USER",
                            "",
                            nomTF.getText(),
                            prenomTF.getText(),
                            villeTF.getText(),
                            dateNaissanceTF.getPicker().getDate(),
                            selectedImage
                    ));
                    showBackAndRefresh();
                } else {
                    Dialog.show("Erreur", "Erreur de modification de user. Code d'erreur : " + responseCode, new Command("Ok"));
                }
            }
        });
    }

    private void showBackAndRefresh() {
        ((MyProfile) previous).refresh();
        previous.showBack();
    }

    private boolean controleDeSaisie() {


        if (emailTF.getText().equals("")) {
            Dialog.show("Avertissement", "Email vide", new Command("Ok"));
            return false;
        }



        if (nomTF.getText().equals("")) {
            Dialog.show("Avertissement", "Nom vide", new Command("Ok"));
            return false;
        }


        if (prenomTF.getText().equals("")) {
            Dialog.show("Avertissement", "Prenom vide", new Command("Ok"));
            return false;
        }


        if (villeTF.getText().equals("")) {
            Dialog.show("Avertissement", "Ville vide", new Command("Ok"));
            return false;
        }


        if (dateNaissanceTF.getPicker().getDate() == null) {
            Dialog.show("Avertissement", "Veuillez saisir la dateNaissance", new Command("Ok"));
            return false;
        }


        if (selectedImage == null) {
            Dialog.show("Avertissement", "Veuillez choisir une image", new Command("Ok"));
            return false;
        }


        return true;
    }
}