INSERT INTO Forum_User (name, password, admin) VALUES ('user', 'password', TRUE);
INSERT INTO Forum_Group (name) VALUES ('group 1');
INSERT INTO Group_Member (user_id, forum_group_id) VALUES ('1', '1');
INSERT INTO Topic (title, forum_group_id) VALUES ('topic 1', '1');
INSERT INTO Forum_Message (author, posted, message, topic_id) VALUES ('1', NOW(), 'Hello', '1');
