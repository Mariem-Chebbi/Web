package com.pidev.services;

import com.codename1.components.InfiniteProgress;
import com.codename1.io.*;
import com.codename1.ui.events.ActionListener;
import com.pidev.entities.User;
import com.pidev.utils.Statics;

import java.io.IOException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

public class UserService {

    public static UserService instance = null;
    public int resultCode;
    private ConnectionRequest cr;
    private ArrayList<User> listUsers;

    User user;

    private UserService() {
        cr = new ConnectionRequest();
    }

    public static UserService getInstance() {
        if (instance == null) {
            instance = new UserService();
        }
        return instance;
    }

    public User getUserById(int idUser) {
        cr = new ConnectionRequest();
        cr.setUrl(Statics.BASE_URL + "/user/show");
        cr.setHttpMethod("POST");
        cr.addArgument("id", String.valueOf(idUser));

        cr.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {

                if (cr.getResponseCode() == 200) {
                    user = getOne();
                }

                cr.removeResponseListener(this);
            }
        });

        try {
            cr.setDisposeOnCompletion(new InfiniteProgress().showInfiniteBlocking());
            NetworkManager.getInstance().addToQueueAndWait(cr);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return user;
    }

    public User checkCredentials(String email, String password) {
        cr = new ConnectionRequest();
        cr.setUrl(Statics.BASE_URL + "/user/verif");
        cr.setHttpMethod("POST");
        cr.addArgument("email", email);
        cr.addArgument("password", password);

        cr.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {

                if (cr.getResponseCode() == 200) {
                    user = getOne();
                } else {
                    user = null;
                }

                cr.removeResponseListener(this);
            }
        });

        try {
            cr.setDisposeOnCompletion(new InfiniteProgress().showInfiniteBlocking());
            NetworkManager.getInstance().addToQueueAndWait(cr);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return user;
    }


    private User getOne() {
        try {
            Map<String, Object> obj = new JSONParser().parseJSON(new CharArrayReader(
                    new String(cr.getResponseData()).toCharArray()
            ));

            return new User(
                    (int) Float.parseFloat(obj.get("id").toString()),

                    (String) obj.get("email"),
                    (String) obj.get("roles"),
                    (String) obj.get("password"),
                    (String) obj.get("nom"),
                    (String) obj.get("prenom"),
                    (String) obj.get("ville"),
                    new SimpleDateFormat("dd-MM-yyyy").parse((String) obj.get("dateNaissance")),
                    (String) obj.get("image")

            );

        } catch (IOException | ParseException e) {
            e.printStackTrace();
        }
        return null;
    }

    public ArrayList<User> getAll() {
        listUsers = new ArrayList<>();

        cr = new ConnectionRequest();
        cr.setUrl(Statics.BASE_URL + "/user");
        cr.setHttpMethod("GET");

        cr.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {

                if (cr.getResponseCode() == 200) {
                    listUsers = getList();
                }

                cr.removeResponseListener(this);
            }
        });

        try {
            cr.setDisposeOnCompletion(new InfiniteProgress().showInfiniteBlocking());
            NetworkManager.getInstance().addToQueueAndWait(cr);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return listUsers;
    }

    private ArrayList<User> getList() {
        try {
            Map<String, Object> parsedJson = new JSONParser().parseJSON(new CharArrayReader(
                    new String(cr.getResponseData()).toCharArray()
            ));
            List<Map<String, Object>> list = (List<Map<String, Object>>) parsedJson.get("root");

            for (Map<String, Object> obj : list) {
                User user = new User(
                        (int) Float.parseFloat(obj.get("id").toString()),

                        (String) obj.get("email"),
                        (String) obj.get("roles"),
                        (String) obj.get("password"),
                        (String) obj.get("nom"),
                        (String) obj.get("prenom"),
                        (String) obj.get("ville"),
                        new SimpleDateFormat("dd-MM-yyyy").parse((String) obj.get("dateNaissance")),
                        (String) obj.get("image")

                );

                listUsers.add(user);
            }
        } catch (IOException | ParseException e) {
            e.printStackTrace();
        }
        return listUsers;
    }

    public int add(User user) {
        return manage(user, false, true);
    }

    public int edit(User user, boolean imageEdited) {
        return manage(user, true, imageEdited);
    }

    public int manage(User user, boolean isEdit, boolean imageEdited) {

        MultipartRequest cr = new MultipartRequest();
        cr.setFilename("file", "User.jpg");


        cr.setHttpMethod("POST");
        if (isEdit) {
            cr.setUrl(Statics.BASE_URL + "/user/edit");
            cr.addArgumentNoEncoding("id", String.valueOf(user.getId()));
        } else {
            cr.setUrl(Statics.BASE_URL + "/user/add");
        }

        if (imageEdited) {
            try {
                cr.addData("file", user.getImage(), "image/jpeg");
            } catch (IOException e) {
                e.printStackTrace();
            }
        } else {
            cr.addArgumentNoEncoding("image", user.getImage());
        }

        cr.addArgumentNoEncoding("email", user.getEmail());
        cr.addArgumentNoEncoding("roles", user.getRoles());
        cr.addArgumentNoEncoding("password", user.getPassword());
        cr.addArgumentNoEncoding("nom", user.getNom());
        cr.addArgumentNoEncoding("prenom", user.getPrenom());
        cr.addArgumentNoEncoding("ville", user.getVille());
        cr.addArgumentNoEncoding("dateNaissance", new SimpleDateFormat("dd-MM-yyyy").format(user.getDateNaissance()));
        cr.addArgumentNoEncoding("image", user.getImage());


        cr.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultCode = cr.getResponseCode();
                cr.removeResponseListener(this);
            }
        });
        try {
            cr.setDisposeOnCompletion(new InfiniteProgress().showInfiniteBlocking());
            NetworkManager.getInstance().addToQueueAndWait(cr);
        } catch (Exception ignored) {

        }
        return resultCode;
    }

    public int delete(int userId) {
        cr = new ConnectionRequest();
        cr.setUrl(Statics.BASE_URL + "/user/delete");
        cr.setHttpMethod("POST");
        cr.addArgument("id", String.valueOf(userId));

        cr.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                cr.removeResponseListener(this);
            }
        });

        try {
            cr.setDisposeOnCompletion(new InfiniteProgress().showInfiniteBlocking());
            NetworkManager.getInstance().addToQueueAndWait(cr);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return cr.getResponseCode();
    }
}
