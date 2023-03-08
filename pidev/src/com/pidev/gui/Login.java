package com.pidev.gui;

import com.codename1.ui.*;
import com.codename1.ui.layouts.BoxLayout;
import com.pidev.MainApp;
import com.pidev.entities.User;
import com.pidev.services.UserService;

public class Login extends Form {

    public static Form loginForm;

    public Login() {
        super("Connexion", new BoxLayout(BoxLayout.Y_AXIS));
        loginForm = this;
        addGUIs();
    }

    private void addGUIs() {


        TextField emailTF = new TextField("");
        emailTF.setHint("Tapez votre email");

        TextField passwordTF = new TextField("", "Tapez votre mot de passe", 20, TextField.PASSWORD);

        Button connectBtn = new Button("Connexion");
        
        connectBtn.setUIID("buttonWhiteCenter");
        connectBtn.addActionListener(l -> connexion(emailTF.getText(), passwordTF.getText()));

        Label registerLabel = new Label("Besoin d'un compte ?");

        Button registerBtn = new Button("Register");
        registerBtn.setUIID("buttonWhiteCenter");
        registerBtn.addActionListener(l -> new com.pidev.gui.Register(this).show());

        this.addAll(emailTF, passwordTF, connectBtn, registerLabel, registerBtn);


        Button backendBtn = new Button("Back");
        backendBtn.addActionListener(l -> new com.pidev.gui.UTIL.AccueilBack().show());

        this.add(backendBtn);
    }

    private void connexion(String email, String password) {
        User user = UserService.getInstance().checkCredentials(email, password);

        if (user != null) {
            MainApp.setSession(user);
            new com.pidev.gui.travail.AccueilFront().show();
        } else {
            Dialog.show("Erreur", "Identifiants invalides", new Command("Ok"));
        }
    }
}
