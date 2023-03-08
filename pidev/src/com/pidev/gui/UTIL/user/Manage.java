package com.pidev.gui.UTIL.user;


import com.codename1.capture.Capture;
import com.codename1.components.ImageViewer;
import com.codename1.ui.*;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.UIManager;
import com.codename1.ui.util.Resources;
import com.pidev.entities.User;
import com.pidev.services.UserService;
import com.pidev.utils.AlertUtils;
import com.pidev.utils.Statics;

import java.io.IOException;

public class Manage extends Form {


    Resources theme = UIManager.initFirstTheme("/theme");
    String selectedImage;
    boolean imageEdited = false;


    User currentUser;

    TextField emailTF;
    TextField nomTF;
    TextField prenomTF;
    TextField villeTF;
    TextField imageTF;
    Label emailLabel;
    Label nomLabel;
    Label prenomLabel;
    Label villeLabel;
    Label imageLabel;
    PickerComponent dateNaissanceTF;


    ImageViewer imageIV;
    Button selectImageButton;

    Button manageButton;

    Form previous;

    public Manage(Form previous) {
        super(ShowAll.currentUser == null ? "Ajouter" : "Modifier", new BoxLayout(BoxLayout.Y_AXIS));
        this.previous = previous;

        currentUser = ShowAll.currentUser;

        addGUIs();
        addActions();

        getToolbar().addMaterialCommandToLeftBar("  ", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    }

    private void addGUIs() {


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

        if (currentUser == null) {

            imageIV = new ImageViewer(theme.getImage("default.jpg").fill(1100, 500));


            manageButton = new Button("Ajouter");
        } else {
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
        }
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

        if (currentUser == null) {
            manageButton.addActionListener(action -> {
                if (controleDeSaisie()) {
                    int responseCode = UserService.getInstance().add(
                            new User(
                                    emailTF.getText(),
                                    "ROLE_USER",
                                    "",
                                    nomTF.getText(),
                                    prenomTF.getText(),
                                    villeTF.getText(),
                                    dateNaissanceTF.getPicker().getDate(),
                                    selectedImage
                            )
                    );
                    if (responseCode == 200) {
                        AlertUtils.makeNotification("User ajouté avec succes");
                        showBackAndRefresh();
                    } else {
                        Dialog.show("Erreur", "Erreur d'ajout de user. Code d'erreur : " + responseCode, new Command("Ok"));
                    }
                }
            });
        } else {
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
                        AlertUtils.makeNotification("User modifié avec succes");
                        showBackAndRefresh();
                    } else {
                        Dialog.show("Erreur", "Erreur de modification de user. Code d'erreur : " + responseCode, new Command("Ok"));
                    }
                }
            });
        }
    }

    private void showBackAndRefresh() {
        ((ShowAll) previous).refresh();
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