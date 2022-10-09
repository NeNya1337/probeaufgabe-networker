
--
-- Table structure for table `crm_data`
--

DROP TABLE IF EXISTS `crm_data`;
CREATE TABLE `crm_data` (
                            `id` int(11) NOT NULL,
                            `name` varchar(30) NOT NULL,
                            `mail` varchar(100) NOT NULL,
                            `hash` varchar(100) NOT NULL,
                            `send_date` datetime DEFAULT NULL,
                            `wants_delete` tinyint(4) DEFAULT NULL,
                            `response_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_data`
--
ALTER TABLE `crm_data`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `crm_data` ADD INDEX(`hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_data`
--
ALTER TABLE `crm_data`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;