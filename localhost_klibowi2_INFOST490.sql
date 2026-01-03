--
-- Database: `klibowi2_INFOST490`
--
CREATE DATABASE IF NOT EXISTS `klibowi2_INFOST490` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `klibowi2_INFOST490`;

-- --------------------------------------------------------

--
-- Table structure for table `blogposts`
--

DROP TABLE IF EXISTS `blogposts`;
CREATE TABLE `blogposts` (
  `blogpost_id` int NOT NULL,
  `user_id` int NOT NULL,
  `blogpost_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `blogpost_body` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `blogpost_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blogposts`
--

INSERT INTO `blogposts` (`blogpost_id`, `user_id`, `blogpost_title`, `blogpost_body`, `blogpost_timestamp`) VALUES
(10, 2, 'Exciting New Features Coming Soon', 'We’re thrilled to announce some exciting new features that will enhance your experience on our platform. Stay tuned for updates that will bring improved functionality and a more user-friendly interface!', '2023-12-16 08:56:00'),
(13, 2, 'Exploring the Latest Trends in Tech', 'In this blog post, we dive into the latest trends in technology, exploring innovations that are shaping our future. From AI advancements to sustainable tech solutions, discover how these trends are influencing our daily lives and what to expect in the coming years.', '2023-12-18 02:59:15'),
(14, 2, 'Big Announcement!', 'This is a blog about a big announcement which is that the blog post about the big announcement has been posted!', '2023-12-18 06:16:25'),
(16, 2, 'Critical Update', 'Critically critical update about the critical update that critically updates the update.', '2023-12-18 06:18:07'),
(19, 2, 'A recipe!', 'Here is a chocolate chip cookie recipe for the perfect treat! Preheat your oven to 350°F, cream together 1 cup of softened butter, 1 cup of brown sugar, and ½ cup of granulated sugar. Mix in 2 large eggs and 1 teaspoon of vanilla extract. In a separate bowl, whisk together 2 ½ cups of all-purpose flour, 1 teaspoon of baking soda, and ½ teaspoon of salt. Gradually combine the dry ingredients with the wet mixture, then fold in 2 cups of chocolate chips. Scoop tablespoons of dough onto a baking sheet and bake for 10-12 minutes until golden brown.', '2025-01-31 02:00:39'),
(20, 2, 'Testing Phase: Share Your Feedback', 'We’re currently in the testing phase of our new updates and would love your feedback! Please take a moment to share your thoughts on the new features and improvements. Your input is invaluable to us as we strive to enhance your experience.', '2025-01-31 02:03:12'),
(21, 2, 'A Closer Look at Our Upcoming Projects', 'Join us as we take a closer look at some of our upcoming projects. We’re excited to share insights into our development process and what you can expect from our team in the near future. Stay tuned for more updates!', '2025-01-31 02:03:58'),
(22, 2, 'Content Testing: Help Us Improve', 'We are conducting a content test to improve our platform\'s offerings. Your participation will help us understand what content resonates best with our audience. Thank you for being a part of our community!', '2025-02-07 00:33:02'),
(23, 2, 'Behind the Scenes: Our Development Journey', 'In this post, we give you a behind-the-scenes look at our development journey. From brainstorming sessions to coding challenges, learn how our team collaborates to bring you the best possible experience.', '2025-02-16 23:45:52'),
(24, 2, 'Quick Update: What’s New?', 'Just a quick update to keep you in the loop! We’ve made some changes and improvements to our site that we think you’ll love. Check back often for more news and updates.', '2025-02-21 04:50:40'),
(25, 2, 'Hello from Our Team!', 'We\'re excited to connect with you! In this post, we want to share updates about our team and the projects we’re currently working on. Stay tuned for more insights and behind-the-scenes looks at what we do! Thank you for reading!', '2025-02-22 04:13:10'),
(27, 2, 'test', 'test', '2025-04-16 17:22:44'),
(28, 2, 'another test', 'another test', '2025-04-16 17:29:06'),
(29, 2, 'A new blogpost', 'I am making a new blog post!', '2025-04-19 02:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `blogpost_id` int NOT NULL,
  `comment_body` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `comment_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `blogpost_id`, `comment_body`, `comment_timestamp`) VALUES
(49, 14, 13, 'Testing testing 123! ABC and doe rae me!', '2023-12-18 05:46:56'),
(50, 15, 13, 'hi', '2023-12-18 05:47:15'),
(51, 15, 10, 'This is cool! Will keep in mind!', '2023-12-18 06:04:07'),
(60, 2, 21, 'Hello I am leaving a comment', '2025-01-31 02:10:26'),
(61, 21, 21, 'Hi!', '2025-02-06 01:00:13'),
(63, 22, 16, 'Hey Dee, here is your comment!', '2025-02-07 00:35:58'),
(64, 2, 22, 'hi', '2025-02-20 04:16:41'),
(65, 2, 23, 'Sounds great!', '2025-02-20 22:00:22'),
(66, 31, 10, 'Great insights on this topic! I really enjoyed reading this.', '2025-02-22 04:21:22'),
(67, 31, 13, 'This post resonates with me. Thank you for sharing!', '2025-02-22 04:21:22'),
(68, 32, 14, 'I found this information very useful. Keep it up!', '2025-02-22 04:21:22'),
(69, 32, 16, 'This is great.', '2025-02-22 04:21:22'),
(70, 33, 19, 'This recipe sounds delicious! I can\'t wait to try it.', '2025-02-22 04:21:22'),
(71, 33, 20, 'Thanks, I\'ll be on the watch!', '2025-02-22 04:21:22'),
(72, 34, 21, 'I am interested in reading more!', '2025-02-22 04:21:22'),
(73, 34, 22, 'This is wonderful!', '2025-02-22 04:21:22'),
(74, 35, 23, 'Article was spot on! I appreciate the motivation.', '2025-02-22 04:21:22'),
(75, 35, 24, 'I always enjoy reading your posts. Very engaging content.', '2025-02-22 04:21:22'),
(76, 36, 10, 'Loved this post!', '2025-02-22 04:21:22'),
(77, 36, 19, 'Such a helpful guide! I will definitely try these tips.', '2025-02-22 04:21:22'),
(78, 39, 25, 'This is the best day of my life!', '2025-02-22 04:50:13'),
(79, 41, 25, 'A new comment!', '2025-02-23 18:59:52'),
(80, 2, 25, 'Hello', '2025-03-05 18:23:10'),
(82, 43, 19, 'This chocolate chip cookie recipe was amazing! Thank you for sharing!', '2025-04-10 21:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pass` char(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bio` text CHARACTER SET latin1 COLLATE latin1_swedish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `registration_date`, `bio`) VALUES
(2, 'Admin', 'Admin', 'Admin@gmail.com', '08efc59730b759d35e55ee200f3dd22a61f6c08914ffee12ab7a17f45c109497', '2023-12-14 02:51:14', 'Administrator.'),
(4, 'Ashley', 'Nicole', 'AshleyNicole@gmail.com', 'f2ca4f73e7dfccf395c8b542339bcad5dd8aa20432d782c4cdd925618c243454', '2023-12-17 09:26:30', 'Passionate about creativity and innovation, always exploring new ideas.'),
(14, 'L', 'M', 'lm@lmmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2023-12-18 05:36:40', 'Tech-savvy problem solver who enjoys learning about new technologies.'),
(15, 'Hi', 'Hi', 'Hi@uwm.edu', '3639efcd08abb273b1619e82e78c29a7df02c1051b1820e99fc395dcaa3326b8', '2023-12-18 05:43:03', 'Enthusiastic about digital trends and emerging technologies.'),
(16, 'z', 'z', 'z@uwm.edu', '594e519ae499312b29433b7dd8a97ff068defcba9755b6d5d00e84c524d67b06', '2023-12-18 05:48:25', 'Curious mind exploring the world of technology and information.'),
(17, 'New', 'Account', 'newaccount@gmail.com', '6ca13d52ca70c883e0f0bb101e425a89e8624de51db2d2392593af6a84118090', '2023-12-18 22:35:56', 'New user discovering the platform and engaging with the community.'),
(18, 't', 't', 't@uwm.edu', 'e3b98a4da31a127d4bde6e43033f66ba274cab0eb7eb1c70ec41402bf6273dd8', '2023-12-23 06:45:02', 'Open to new learning opportunities.'),
(19, 'Author', 'Admin', 'e.learning.siha@gmail.com', 'e399967fdd59bffd34e5e8ec0cd3a91a6eeb51a48abafa0007f7a1adea392f68', '2024-05-08 15:36:41', 'Passion for education.'),
(20, 'Testing', 'System', 'testingsystem@gmail.com', '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824', '2025-01-31 02:16:16', 'Dedicated to ensuring platform stability and performance.'),
(21, '123', '456', '123456@gmail.com', '185f8db32271fe25f561a6fc938b2e264306ec304eda518007d1764826381969', '2025-02-06 00:59:39', 'Exploring the platform and looking for engaging content.'),
(22, 'Dee', 'Piziak', 'Piziak@uwm.edu', '756d8d7c9e37f1b946789d16c86583d5506f9059c2e210041678d94a2d75d4c1', '2025-02-07 00:30:56', NULL),
(23, 'a', 'a', 'a@gmail.com', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', '2025-02-19 22:37:12', 'Enjoys connecting with others and sharing insights.'),
(24, 'he', 'llo', 'hello1@gmail.com', '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824', '2025-02-19 22:57:03', 'Enthusiast of books, technology, and innovative ideas.'),
(25, 'Ashley', 'k', 'ashleyk@gmail.com', 'c64975ba3cf3f9cd58459710b0a42369f34b0759c9967fb5a47eea488e8bea79', '2025-02-19 22:59:39', 'Curious explorer navigating the digital world.'),
(26, 'Noah', 'Anderson', '12@gmail.com', '6b51d431df5d7f141cbececcf79edf3dd861c3b4069f0b11661a3eefacbba918', '2025-02-19 23:00:37', 'Active learner eager to engage with diverse topics.'),
(27, 'Hello', 'Hi', 'Hello@gmail.com', '3639efcd08abb273b1619e82e78c29a7df02c1051b1820e99fc395dcaa3326b8', '2025-02-22 04:03:40', 'Excited to be part of the community and contribute insights.'),
(28, 'New', 'Account', 'newaccount6@gmail.com', '11507a0e2f5e69d5dfa40a62a1bd7b6ee57e6bcd85c67c9b8431b36fff21c437', '2025-02-22 04:09:24', 'Engaged in meaningful discussions and knowledge sharing.'),
(29, 'Test', 'Account', 'Account@gmail.com', '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824', '2025-02-22 04:11:34', 'Avid reader who loves sharing thoughts on various topics.'),
(30, 'testing', 'testing', 'testing@uwm.edu', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', '2025-02-22 04:12:13', 'Tech enthusiast who enjoys exploring new gadgets.'),
(31, 'Alice', 'Johnson', 'alice.johnson@example.com', '$2y$10$UsOB6A5yljzItRx2QV2R9e9IVXc6ggg3Mh4iSWRp1FC9EDwZ2gDkC', '2025-02-22 04:20:00', 'Food lover who enjoys trying new recipes.'),
(32, 'Bob', 'Smith', 'bob.smith@example.com', '$2y$10$JvpLu0nXVPXndqGfSSc2c.UBVZn.B6q7Ar/1iQkjRsAb9E8bv/JVq', '2025-02-22 04:20:00', 'Travel enthusiast who enjoys experiencing new places.'),
(33, 'Cathy', 'Brown', 'cathy.brown@example.com', '$2y$10$G/XEGIOgUjd0f1dPOnBuH.ZO3qpFf0FZxovqtw/N9Q/Nzg0lPL.de', '2025-02-22 04:20:00', 'Fitness fanatic sharing tips on staying active and healthy.'),
(34, 'David', 'Davis', 'david.davis@example.com', '$2y$10$B99MPVQgIL4K5WNr/2ERbuGRuispczSJNFZUFY1Fs8u7KOndnazE6', '2025-02-22 04:20:00', 'Nature lover who enjoys spending time outdoors.'),
(35, 'Eva', 'Wilson', 'eva.wilson@example.com', '$2y$10$aIaqy0N5JaMgh/aG4r4Xhua2c7AulRbsTNB5H5pMNdlNKXKdTR6Na', '2025-02-22 04:20:00', 'Fitness fanatic sharing tips on staying active and healthy.'),
(36, 'Frank', 'Miller', 'frank.miller@example.com', '$2y$10$5qL.L3KIXB/j4ca8GRzK5.r1lNAur7TiQQLJHb8LEBVNmJ.6GKMMi', '2025-02-22 04:20:00', 'Lifelong learner passionate about technology, creativity, and problem-solving.'),
(37, 'Grace', 'Lee', 'grace.lee@example.com', 'hashed_password7', '2025-02-22 04:20:00', 'Passionate about sustainability and eco-friendly living.'),
(38, 'Henry', 'Clark', 'henry.clark@example.com', 'hashed_password8', '2025-02-22 04:20:00', 'Music lover always exploring new genres.'),
(39, 'M', 'L', 'ml@mlmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2025-02-22 04:48:22', NULL),
(40, 'Abc', 'Cba', 'abc@mail.com', 'ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad', '2025-02-22 04:53:18', NULL),
(41, 'Andrea', 'Lilo', 'AndreaLilo@gmail.com', '253387e8620ee1896c76809782406e139bce35860aaa0d61991965319ba0dc32', '2025-02-23 18:55:04', 'My Bio'),
(42, 'io', 'io', 'io@gmaill.com', '3614f7e180d9000547fe4b19cbdb4d222cdd4d4675a023588a69fbe2d1140189', '2025-03-05 18:30:44', NULL),
(43, 'Bao', 'Lee', 'baoslee@uwm.edu', '08b71ca4829075a84bbb9afd55f72abe8bcb30d88d6de51c2f8689aaca577610', '2025-04-10 06:43:36', ''),
(44, 'Bob', 'Smith', '123@email.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2025-04-17 16:23:05', NULL),
(45, 'A New', 'Account', 'new@gmail.com', '11507a0e2f5e69d5dfa40a62a1bd7b6ee57e6bcd85c67c9b8431b36fff21c437', '2025-04-18 17:44:14', NULL),
(46, 'User', 'Testing', 'usertesting@gmail.com', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', '2025-04-21 17:35:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogposts`
--
ALTER TABLE `blogposts`
  ADD PRIMARY KEY (`blogpost_id`),
  ADD KEY `blogposts_ibfk_1` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comments_ibfk_2` (`blogpost_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogposts`
--
ALTER TABLE `blogposts`
  MODIFY `blogpost_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogposts`
--
ALTER TABLE `blogposts`
  ADD CONSTRAINT `blogposts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`blogpost_id`) REFERENCES `blogposts` (`blogpost_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
