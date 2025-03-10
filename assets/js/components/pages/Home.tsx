import { useEffect, useState } from "react";
import { motion } from "framer-motion";
import { useFetchAniversariantes } from "@components/api/useFetchAniversariantes";
import { Box, Text, Image, Flex, Spinner, Center, Icon, VStack, Button, useColorModeValue, HStack } from "@chakra-ui/react";
import { FaBirthdayCake, FaGift, FaChevronLeft, FaChevronRight, FaRegSmile, FaUserGraduate, FaChalkboardTeacher } from "react-icons/fa";

export default function AniversariantesSlide() {
  const { dados, loading } = useFetchAniversariantes();
  const [index, setIndex] = useState(0);

  useEffect(() => {
    if (dados && Object.keys(dados.dados).length > 0) {
      const interval = setInterval(() => {
        setIndex((prevIndex) => (prevIndex + 1) % Object.keys(dados.dados).length);
      }, 4000);
      return () => clearInterval(interval);
    }
  }, [dados]);

  if (loading)
    return (
      <Center h="100vh" bgGradient="linear(to-r, #1a1a2e, #16213e)">
        <Spinner size="xl" color="white" />
      </Center>
    );

  if (!dados || Object.keys(dados.dados).length === 0)
    return (
      <Center h="100vh" bgGradient="linear(to-r, #1a1a2e, #16213e)">
        <Text fontSize="xl" color="white">Nenhum aniversariante encontrado.</Text>
      </Center>
    );

  const aniversariantes = Object.values(dados.dados);
  const pessoa = aniversariantes[index];
  const turma = pessoa.cargo.nome === "ALUNO" && pessoa.turma ? Object.values(pessoa.turma)[0] : "";

  const bgColor = useColorModeValue("whiteAlpha.300", "whiteAlpha.200");
  const borderColor = useColorModeValue("rgba(255, 255, 255, 0.2)", "rgba(255, 255, 255, 0.1)");
  const pessoaBgColor = pessoa.cargo.nome === "ALUNO" ? "blue.500" : "purple.500";
  const tipoNiver = dados.Aniversariantes === "mensal" ? "Mês" : "Dia";

  return (
    <Flex direction="column" align="center" justify="center" h="100vh" bgGradient="linear(to-r, #1d3c6d, #3b5f84, #2c4f69)" color="white" p={8} position="relative">
      <Box>
        {/* <Image src="https://telegra.ph/file/daa4ccd71a49aae9a7cc9.png" alt="Logo" position="absolute" top={4} left={4} w={20} opacity={0.9} /> */}
      </Box>

      <Text fontSize="4xl" fontWeight="bold" mb={6} display="flex" alignItems="center" letterSpacing="wide" textShadow="2px 2px 4px rgba(0, 0, 0, 0.6)">
        <Icon as={FaBirthdayCake} mr={3} color="yellow.400" /> Aniversariantes do {tipoNiver}
      </Text>

      <Box position="relative" display="flex" alignItems="center" justifyContent="center" w="full" maxW="2xl" h={96} bg={bgColor} rounded="3xl" shadow="2xl" p={8} textAlign="center" border="2px solid" borderColor={borderColor}>
        <motion.div
          key={index}
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          exit={{ opacity: 0, scale: 0.9 }}
          transition={{ duration: 0.6 }}
        >
          <VStack spacing={6}>
            <Box bg={pessoaBgColor} p={5} borderRadius="full" boxShadow="md">
              <Icon as={pessoa.cargo.nome === "ALUNO" ? FaUserGraduate : FaChalkboardTeacher} boxSize={12} color="white" />
            </Box>

            <VStack spacing={2}>
              <Text fontSize="3xl" fontWeight="bold" textTransform="uppercase" letterSpacing="wide" noOfLines={1}>
                {pessoa.nome}
              </Text>
              <Text fontSize="xl" color="yellow.300" fontWeight="semibold">
                {pessoa.cargo.nome}
              </Text>
              {turma && (
                <Text fontSize="lg" color="gray.200">
                  {turma}
                </Text>
              )}
            </VStack>

            <HStack spacing={4} align="center">
              <Text fontSize="md" color="gray.300">
                {pessoa.dataNascimento}
              </Text>
              <Icon as={FaGift} color="pink.300" boxSize={8} />
            </HStack>
          </VStack>
        </motion.div>
      </Box>

      <Flex mt={8} justify="space-between" w="full" maxW="2xl">
        <Button
          onClick={() => setIndex((index - 1 + aniversariantes.length) % aniversariantes.length)}
          leftIcon={<FaChevronLeft />}
          colorScheme="yellow"
          variant="solid"
          size="lg"
          boxShadow="md"
        />
        <Button
          onClick={() => setIndex((index + 1) % aniversariantes.length)}
          rightIcon={<FaChevronRight />}
          colorScheme="yellow"
          variant="solid"
          size="lg"
          boxShadow="md"
        />
      </Flex>

      <Text mt={6} fontSize="2xl" color="gray.300" display="flex" alignItems="center">
        <Icon as={FaRegSmile} color="green.300" mr={2} /> Felicitações especiais para todos!
      </Text>

      <Box position="absolute" bottom={4} right={4} opacity={0.3}>
        <Icon as={FaBirthdayCake} boxSize={12} color="yellow.400" />
      </Box>
    </Flex>
  );
}